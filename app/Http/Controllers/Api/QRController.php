<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendRestoreScreenJob;
use App\Models\QRCode;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class QRController extends Controller
{

    // إعدادات الجهاز
    private $insPwd;

    public function __construct()
    {
        // يفضل وضع هذا في env بدلاً من الكود
        $this->insPwd = env('KAPRI_INS_PWD', null);
    }

    public function handle2(Request $request)
    {
        $event = $request->all();

        // 1. تحقق سريع من التوكن الخاص بالجهاز (Security)
        if (($event['msgArg']['sToken'] ?? '') !== config('app.kapri_token', 'test-123456789')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // 2. التحقق من وجود البيانات
        $qrToken = $event['msgArg']['sData'] ?? null;
        if (!$qrToken) {
            return $this->respondWithError("QR Token Missing");
        }

        // 3. البحث عن الـ QR واليوزر واشتراكه باستعلام واحد (Performance Boost)
        $hours = getSetting('qr_expiration_hours', 12);

        $qr = QrCode::with(['user.current_subscription']) // جلب العلاقات فوراً
        ->where('qr_token', $qrToken)
            ->where('updated_at', '>', Carbon::now()->subHours($hours)) // أسرع من Raw SQL
            ->first();

        // 4. سيناريوهات الرفض (Validation)
        if (!$qr) {
            return $this->respondWithError("Expired or Invalid QR");
        }

        $user = $qr->user;
        if (!$user) {
            return $this->respondWithError("User Not Found");
        }

        if (!$user->current_subscription) {
            return $this->respondWithError("Subscription Expired");
        }

        // 5. معالجة المنطق (Business Logic) داخل Transaction لضمان سلامة البيانات
        try {
            DB::transaction(function () use ($qr, $user) {
                if ($qr->type == "visitor" && $qr->status == "pending") {
                    $subscription = $user->current_subscription;

                    if ($subscription->last_guests_limit <= 0) {
                        throw new \Exception("Guest Limit Reached");
                    }

                    $subscription->increment('used_guests');
                    $subscription->decrement('last_guests_limit');
                }

                // تحديث الحالة وتسجيل الزيارة
                if ($qr->status !== 'checked_in') {
                    $qr->update(['status' => 'checked_in']);
                }
                $user->visitHistories()->create([]);
            });
        } catch (\Exception $e) {
            // التقاط الخطأ من داخل الترانزاكشن (مثل انتهاء رصيد الضيوف)
            return $this->respondWithError($e->getMessage());
        }

        // 6. الرد بالنجاح وفتح الباب
        return $this->respondWithSuccess($user, $qr->type);
    }

    private function respondWithSuccess($user, $type)
    {
        $welcomeText = "Welcome " . ($type == "visitor" ? "Guest" : "") . "<br>" . e($user->name);

        // شاشة خضراء أو سوداء للترحيب
        $html = $this->generateHtmlResponse($welcomeText, '#000000', '#2ecc71');

        $listBatch = [];

        // 1. تشغيل الريلاي (فتح الباب)
        $listBatch[] = [
            'msgType' => 'ins_inout_relay_operate',
            'msgArg'  => [
                'sPosition' => 'main',
                'sMode'     => 'on',
                "ucRelayNum"=> 0,
                'ucTime_ds' => 50, // 5 ثواني
            ]
        ];

        // 2. صوت نجاح (نغمة قصيرة)
        $listBatch[] = [
            'msgType' => 'ins_inout_buzzer_operate',
            'msgArg'  => $this->filterArgs([
                'sPosition' => 'main',
                'sMode'     => 'on',
                'ucTime_ds' => 2, // 0.2 ثانية
            ]),
        ];

        // 3. عرض رسالة الترحيب
        $listBatch[] = [
            'msgType' => 'ins_screen_html_document_write',
            'msgArg'  => $this->filterArgs(['sHtml' => $html]),
        ];

        return response()->json([
            'msgType' => 'ins_cloud_batch',
            'msgArg'  => ['bReply' => true, 'listBatch' => $listBatch],
        ]);
    }


    public function storeQR(Request $request){
        $validated = $request->validate([
            "qr_token" => "required"]);

        $qr = QRCode::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'type'    => 'member',
            ],
            [
                'qr_token'   => $validated['qr_token'],
                'guests'     => $validated['guests'] ?? 0,
                'status'     => 'pending',
                'created_by' => auth()->id(),
                'expires_at' => now()->addDay(),
            ]
        );

        return response()->json([
            "status"=>true,
            'message' => 'QR code saved successfully',
            'data'    => $qr
        ]);
    }
    public function storeNumGuests(Request $request)
    {
        $validated = $request->validate([
            'guests_count' => 'required|numeric|min:0',
        ]);

        $user = auth()->user();

        if ($user->subscription and $user->plan->used_guests<=$user->plan->guest_passes_per_year) {
            $user->subscription->update([
                'last_guests_limit' => $validated['guests_count']
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Guests limit updated successfully.',
                'data' => [
                    'last_guests_limit' => $validated['guests_count']
                ]
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'The number of guests available for the plan has been consumed.'
            ], 404);
        }

        return response()->json([
            'status' => false,
            'message' => 'No subscription found for this user.'
        ], 404);
    }

//    public function handle(Request $request)
//    {
//        $event = $request->all();
//        \Log::info('Kapri Event Received:', $event);
//
//        $sInsPwd = env('KAPRI_INS_PWD');
//        $listBatch = [];
//
//        $sendErrorToDevice = function ($message) use ($sInsPwd) {
//            return [
//                'msgType' => 'ins_screen_html_document_write',
//                'msgArg'  => array_filter([
//                    'sHtml' => "
//                    <html>
//                      <body style='background-color:#000; text-align:center; color:red; font-family:Arial;'>
//                        <div style='margin-top:40px; font-size:22px;'>
//                          <b>{$message}</b>
//                        </div>
//                      </body>
//                    </html>",
//                    'sInsPwd' => $sInsPwd,
//                ], fn($v) => $v !== null),
//            ];
//        };
//
//        $returnBatch = function ($batch) {
//            return response()->json([
//                'msgType' => 'ins_cloud_batch',
//                'msgArg'  => [
//                    'bReply'    => true,
//                    'listBatch' => $batch,
//                ],
//            ]);
//        };
//
//        if (($event['msgArg']['sToken'] ?? '') !== 'test-123456789') {
//            $listBatch[] = $sendErrorToDevice('Unauthorized Access');
//            return $returnBatch($listBatch);
//        }
//
//        $qrToken = $event['msgArg']['sData'] ?? null;
//        if (!$qrToken) {
//            $listBatch[] = $sendErrorToDevice('QR Token Missing');
//            return $returnBatch($listBatch);
//        }
//
//        $hours = getSetting('qr_expiration_hours', 12);
//
//        $qr = QrCode::where('qr_token', $qrToken)
//            ->whereRaw('TIMESTAMPADD(HOUR, ?, updated_at) > NOW()', [$hours])
//            ->first();
//
//        if (!$qr) {
//            $listBatch[] = $sendErrorToDevice('QR Not Valid or Expired');
//            return $returnBatch($listBatch);
//        }
//
//        $user = $qr->user;
//
//        if ($user->subscription->last_guests_limit == 0) {
//            $listBatch[] = $sendErrorToDevice('Guests Limit Reached');
//            return $returnBatch($listBatch);
//        }
//
//        if (is_null($user->current_subscription)) {
//            $listBatch[] = $sendErrorToDevice('Subscription Expired');
//            return $returnBatch($listBatch);
//        }
//
//        $qr->update(['status' => 'checked_in']);
//        $user->visitHistories()->create([]);
//
//        if ($qr->type == "visitor") {
//            $user->subscription->increment('used_guests');
//            $user->subscription->decrement('last_guests_limit');
//        }
//
//        if (($event['msgType'] ?? '') === 'on_uart_receive') {
//            $listBatch[] = [
//                'msgType' => 'ins_inout_relay_operate',
//                'msgArg'  => [
//                    'sPosition' => 'main',
//                    'sMode'     => 'on',
//                    'ucRelayNum'=> 0,
//                    'ucTime_ds' => 50,
//                ],
//            ];
//
//            $buzzer = [
//                'msgType' => 'ins_inout_buzzer_operate',
//                'msgArg'  => array_filter([
//                    'sPosition' => 'main',
//                    'sMode'     => 'on',
//                    'ucTime_ds' => 1,
//                    'sInsPwd'   => $sInsPwd,
//                ], fn($v) => $v !== null),
//            ];
//            $listBatch[] = $buzzer;
//
//            if (!empty($event['msgArg']['sData'])) {
//                $safe = e($event['msgArg']['sData']);
//                $html = <<<HTML
//            <html>
//              <body style="background-color:#000; text-align:center; font-family:Arial, sans-serif;">
//                <div style="margin-top:10px;">
//                  <img src="boot.jpg" width="160" style="margin-top:10px;"/>
//                  <h2 style="color:#0f0;">Welcome {$user->name}</h2>
//                  <div id="id_dt_hhmm" style="color:white; margin-top:5px; font-size:24px;"></div>
//                </div>
//              </body>
//            </html>
//HTML;
//
//                $listBatch[] = [
//                    'msgType' => 'ins_screen_html_document_write',
//                    'msgArg'  => array_filter([
//                        'sHtml'   => $html,
//                        'sInsPwd' => $sInsPwd,
//                    ], fn($v) => $v !== null),
//                ];
//
//                $restoreHtml = <<<HTML
//            <html>
//              <body style="background-color:#000; text-align:center; font-family:Arial, sans-serif;">
//                <img src="boot.jpg" width="160" style="margin-top:40px;"/>
//                <div id="id_dt_hhmm" style="color:white; margin-top:20px; font-size:24px;"></div>
//              </body>
//            </html>
//HTML;
//
//            }
//        }
//
//          return $returnBatch($listBatch);
//    }

    public function handle_ORIGINAL(Request $request)
    {
        $event = $request->all();
        \Log::info('Kapri Event Received:', $event);


        if (($event['msgArg']['sToken'] ?? '') !== 'test-123456789') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $qrToken = $event['msgArg']['sData'] ?? null;

        if (!$qrToken) {
            return response()->json(['error' => 'QR token missing'], 400);
        }


        $hours = getSetting('qr_expiration_hours', 12);

        $qr = QrCode::where('qr_token', $qrToken)
            ->WhereRaw('TIMESTAMPADD(HOUR, ?, updated_at) > NOW()', [$hours])
            ->first();



        if (!$qr) {
            return response()->json(['error' => 'QR not valid or expired'], 401);
        }
        $user = $qr->user ?? null;

        if(!is_null($user)) {


            if (is_null($user->current_subscription)) {
                return response()->json(['error' => 'Subscription Expired'], 401);

            }
            if ($qr->type == "visitor" and $qr->status == "pending") {
                $user->subscription->increment('used_guests');
                if ($user->subscription->last_guests_limit > 0) {
                    $user->subscription->decrement('last_guests_limit');
                }                if ($user->subscription->last_guests_limit <= 0) {
                    return response()->json(['error' => 'QR not valid or expired'], 401);

                }
            }


            $updated = $qr->update(['status' => 'checked_in']);


            $user->visitHistories()->create([]);
        }

        $listBatch = [];

        if (($event['msgType'] ?? '') === 'on_uart_receive') {

            // If you configured an instruction password on the device (interface_ins_pwd),
        //  you MUST include it in each instruction's msgArg as "sInsPwd": "<your_password>".
//  Remove the line if you didn’t set that parameter.
            $sInsPwd = env('KAPRI_INS_PWD'); // or null if not used




            // 3 sec buzzer
            $listBatch[] = [
                'msgType' => 'ins_inout_relay_operate',
                'msgArg'  => [
                    'sPosition' => 'main',
                    'sMode'     => 'on',
                    "ucRelayNum"=> 0,
                    'ucTime_ds' => 50,
                ]
            ];

            $buzzer = [
                'msgType' => 'ins_inout_buzzer_operate',
                'msgArg'  => array_filter([
                    'sPosition' => 'main',
                    'sMode'     => 'on',     // أو 'beep_50' لنبضات متقطعة
                    'ucTime_ds' => 1,
                    'sInsPwd'   => $sInsPwd,
                ], fn($v) => $v !== null),
            ];

            $listBatch[] = $buzzer;

            $welcome = "Welcome " . ($qr->type == "visitor" ? "Guest " : "") . ($user->name ?? "");


            if (!empty($event['msgArg']['sData'])) {
                $safe = e($event['msgArg']['sData']);
                $html = <<<HTML
            <html>
              <body style="background-color:#000; text-align:center; font-family:Arial, sans-serif;">
                <div style="margin-top:10px;">
                <img src="boot.jpg" width="160" style="margin-top:10px;"/>
                <h2 style="color:#333;">{$welcome}</h2>
                  <div id="id_dt_hhmm" style="color:white; margin-top:5px; font-size:24px;"></div>
                </div>
              </body>
            </html>
HTML;

                $listBatch[] = [
                    'msgType' => 'ins_screen_html_document_write',
                    'msgArg'  => array_filter([
                        'sHtml'   => $html,
                        'sInsPwd' => $sInsPwd,
                    ], fn($v) => $v !== null),
                ];


                $restoreHtml = <<<HTML
            <html>
              <body style="background-color:#000; text-align:center; font-family:Arial, sans-serif;">
                <img src="boot.jpg" width="160" style="margin-top:40px;"/>
                <div id="id_dt_hhmm" style="color:white; margin-top:20px; font-size:24px;"></div>
              </body>
            </html>
HTML;

            }
        }

// Always return a valid ins_cloud_batch
        $response = [
            'msgType' => 'ins_cloud_batch',
            'msgArg'  => [
                'bReply'    => true,
                'listBatch' => $listBatch,
            ],
        ];

        return response()->json($response);


    }
    public function handle(Request $request)
    {
        $event = $request->all();
        \Log::info('Kapri Event Received:', $event);

        // تجهيز متغيرات الرد الافتراضية
        $sInsPwd = env('KAPRI_INS_PWD'); // كلمة مرور الجهاز إن وجدت
        $listBatch = []; // قائمة الأوامر
        $errorMessage = null; // لتخزين رسالة الخطأ إن وجدت

        // 1. التحقق من التوكن (Auth)
        if (($event['msgArg']['sToken'] ?? '') !== 'test-123456789') {
            $errorMessage = 'Unauthorized Device';
        }

        // 2. التحقق من وجود بيانات الكود
        $qrToken = $event['msgArg']['sData'] ?? null;
        if (!$errorMessage && !$qrToken) {
            $errorMessage = 'QR Missing';
        }

        // 3. جلب الإعدادات والبحث عن الكود وصلاحية الوقت
        $qr = null;
        $user = null;

        if (!$errorMessage) {
            $hours = getSetting('qr_expiration_hours', 12);

            // الشرط هنا يتحقق أن الوقت الحالي أقل من (وقت التحديث + الساعات المسموحة)
            // هذا يسمح بالدخول المتكرر طالما المعادلة صحيحة
            $qr = QrCode::where('qr_token', $qrToken)
                ->whereRaw('TIMESTAMPADD(HOUR, ?, updated_at) > NOW()', [$hours])
                ->first();

            if (!$qr) {
                $errorMessage = 'QR Expired or Invalid';
            } else {
                $user = $qr->user ?? null;
            }
        }

        // 4. التحقق من اليوزر والاشتراك ومنطق الزوار
        if (!$errorMessage && $user) {

            if (is_null($user->current_subscription)) {
                $errorMessage = 'Subscription Expired';
            }
            else {
                // منطق الزائر (يتم الخصم فقط إذا كانت الحالة Pending)
                // إذا كانت الحالة Checked_in يمرر الكود ولا يخصم مرة أخرى (وهذا يسمح بالدخول والخروج)
                if ($qr->type == "visitor" && $qr->status == "pending") {

                    // تحقق من الرصيد قبل الخصم
                    if ($user->subscription->last_guests_limit <= 0) {
                        $errorMessage = 'Guest Limit Reached';
                    } else {
                        // الخصم وتحديث الحالة
                        $user->subscription->increment('used_guests');
                        $user->subscription->decrement('last_guests_limit');

                        // تحديث الحالة إلى checked_in
                        // ملاحظة مهمة: هذا التحديث سيغير updated_at وبالتالي سيبدأ عد الـ 12 ساعة من هذه اللحظة
                        $qr->update(['status' => 'checked_in']);
                    }
                }

                // تسجيل تاريخ الزيارة (Log)
                if (!$errorMessage) {
                    $user->visitHistories()->create([]);
                }
            }
        } elseif (!$errorMessage && !$user) {
            $errorMessage = 'User Not Found';
        }

        // ============================================================
        // مرحلة بناء الرد (لن نستخدم 401 أبداً لتجنب التعليق)
        // ============================================================

        if ($errorMessage) {
            // --- حالة الخطأ/الرفض ---
            // نرسل أوامر للجهاز: شغل صوت خطأ + اعرض رسالة الرفض

            $safeError = e($errorMessage);
            $htmlError = <<<HTML
        <html>
          <body style="background-color:#000; text-align:center; font-family:Arial, sans-serif;">
            <div style="margin-top:40px;">
                <h1 style="color:red; font-size:50px;">X</h1>
                <h3 style="color:white;">{$safeError}</h3>
            </div>
          </body>
        </html>
HTML;

            $listBatch[] = [
                'msgType' => 'ins_inout_buzzer_operate',
                'msgArg'  => [
                    'sPosition' => 'main',
                    'sMode'     => 'beep_error', // نغمة خطأ
                    'ucTime_ds' => 5,
                    'sInsPwd'   => $sInsPwd,
                ]
            ];

            $listBatch[] = [
                'msgType' => 'ins_screen_html_document_write',
                'msgArg'  => [
                    'sHtml'   => $htmlError,
                    'sInsPwd' => $sInsPwd,
                ]
            ];

        } else {
            // --- حالة النجاح ---
            // نرسل أوامر: فتح الباب + صوت نجاح + ترحيب

            // 1. فتح الريلاي
            $listBatch[] = [
                'msgType' => 'ins_inout_relay_operate',
                'msgArg'  => [
                    'sPosition' => 'main',
                    'sMode'     => 'on',
                    "ucRelayNum"=> 0,
                    'ucTime_ds' => 50, // 5 ثواني
                    'sInsPwd'   => $sInsPwd,
                ]
            ];

            // 2. صوت صفارة
            $listBatch[] = [
                'msgType' => 'ins_inout_buzzer_operate',
                'msgArg'  => [
                    'sPosition' => 'main',
                    'sMode'     => 'on',
                    'ucTime_ds' => 1,
                    'sInsPwd'   => $sInsPwd,
                ]
            ];

            // 3. الشاشة
            $welcome = "Welcome " . ($qr->type == "visitor" ? "Guest " : "") . ($user->name ?? "");
            $safeWelcome = e($welcome);

            $htmlSuccess = <<<HTML
        <html>
          <body style="background-color:#000; text-align:center; font-family:Arial, sans-serif;">
            <div style="margin-top:10px;">
            <img src="boot.jpg" width="160" style="margin-top:10px;"/>
            <h2 style="color:#2ecc71;">{$safeWelcome}</h2>
              <div id="id_dt_hhmm" style="color:white; margin-top:5px; font-size:24px;"></div>
            </div>
          </body>
        </html>
HTML;

            $listBatch[] = [
                'msgType' => 'ins_screen_html_document_write',
                'msgArg'  => [
                    'sHtml'   => $htmlSuccess,
                    'sInsPwd' => $sInsPwd,
                ]
            ];
        }

        // إرجاع الرد النهائي بصيغة JSON 200 OK دائماً
        return response()->json([
            'msgType' => 'ins_cloud_batch',
            'msgArg'  => [
                'bReply'    => true,
                'listBatch' => $listBatch,
            ],
        ]);
    }

    private function openGate()
    {
        $deviceIp = "192.168.1.100";
        $url = "http://{$deviceIp}:9445/api/instruction";

        $instruction = [
            "msgType" => "ins_inout_relay_switch_on",
            "msgArg" => [
                "relay" => 0,
                "time"  => 5000
            ]
        ];

        Http::post($url, $instruction);
    }

    public function handle4(Request $request)
    {
        // 1. التقاط البيانات وبدء مصفوفة الأوامر فارغة
        $event = $request->all();
        $listBatch = [];
        $sInsPwd = env('KAPRI_INS_PWD', null); // كلمة سر الجهاز إن وجدت

        // يفضل تسجيل اللوج فقط عند الحاجة لتقليل الضغط
        // Log::info('Kapri Event:', $event);

        try {
            // ---------------------------------------------------------
            // 2. التحقق من التوكن (Security Check)
            // ---------------------------------------------------------
            if (($event['msgArg']['sToken'] ?? '') !== 'test-123456789') {
                throw new \Exception("Unauthorized Device");
            }

            // 3. التحقق من وجود بيانات QR
            $qrToken = $event['msgArg']['sData'] ?? null;
            if (!$qrToken) {
                throw new \Exception("QR Missing");
            }

            // ---------------------------------------------------------
            // 4. استعلام قاعدة البيانات (محسن للأداء)
            // ---------------------------------------------------------
            // نستخدم Carbon بدلاً من Raw SQL لسرعة أعلى واستفادة من الكاش الداخلي
            $hours = getSetting('qr_expiration_hours', 12);

            $qr = QrCode::with('user.current_subscription') // Eager Loading
            ->where('qr_token', $qrToken)
                ->where('updated_at', '>', Carbon::now()->subHours($hours))
                ->first();

            if (!$qr) {
                throw new \Exception("Invalid or Expired QR");
            }

            $user = $qr->user;
            if (!$user) {
                throw new \Exception("User Not Found");
            }

            // ---------------------------------------------------------
            // 5. منطق العمل (Business Logic)
            // ---------------------------------------------------------

            // التحقق من الاشتراك
            if (!$user->current_subscription) {
                throw new \Exception("Subscription Expired");
            }

            // منطق خصم الرصيد (تم إصلاح ترتيب العمليات)
            if ($qr->type == "visitor" && $qr->status == "pending") {
                $sub = $user->current_subscription;

                // تحقق قبل الخصم!
                if ($sub->last_guests_limit <= 0) {
                    throw new \Exception("Guest Limit Reached");
                }

                // تنفيذ الخصم
                $sub->increment('used_guests');
                $sub->decrement('last_guests_limit');
            }

            // تحديث حالة QR
            if ($qr->status !== 'checked_in') {
                $qr->update(['status' => 'checked_in']);
            }

            // تسجيل الدخول
            $user->visitHistories()->create([]);

            // ---------------------------------------------------------
            // 6. تجهيز أوامر النجاح (فتح الباب)
            // ---------------------------------------------------------

            // أ. تشغيل الريلاي (فتح الباب)
            $listBatch[] = [
                'msgType' => 'ins_inout_relay_operate',
                'msgArg'  => [
                    'sPosition' => 'main',
                    'sMode'     => 'on',
                    "ucRelayNum"=> 0,
                    'ucTime_ds' => 50, // 5 ثواني
                ]
            ];

            // ب. صوت ترحيب (نغمة قصيرة)
            $listBatch[] = [
                'msgType' => 'ins_inout_buzzer_operate',
                'msgArg'  => $this->filterArgs([
                    'sPosition' => 'main',
                    'sMode'     => 'on',
                    'ucTime_ds' => 2, // 0.2 ثانية
                    'sInsPwd'   => $sInsPwd
                ]),
            ];

            // ج. شاشة الترحيب
            $welcomeMsg = "Welcome " . ($qr->type == "visitor" ? "Guest" : "") . "<br>" . e($user->name);
            $html = $this->getHtml($welcomeMsg, '#000000', '#2ecc71'); // خلفية سوداء، نص أخضر

            $listBatch[] = [
                'msgType' => 'ins_screen_html_document_write',
                'msgArg'  => $this->filterArgs([
                    'sHtml'   => $html,
                    'sInsPwd' => $sInsPwd
                ]),
            ];

        } catch (\Exception $e) {
            // ---------------------------------------------------------
            // 7. معالجة الأخطاء (بدلاً من 401، نرسل أوامر رفض للجهاز)
            // ---------------------------------------------------------

            // أ. صوت خطأ (طويل ومتقطع)
            $listBatch[] = [
                'msgType' => 'ins_inout_buzzer_operate',
                'msgArg'  => $this->filterArgs([
                    'sPosition' => 'main',
                    'sMode'     => 'beep_50',
                    'ucTime_ds' => 10, // 1 ثانية
                    'sInsPwd'   => $sInsPwd
                ]),
            ];

            // ب. شاشة حمراء توضح الخطأ
            $errorMsg = "ACCESS DENIED<br><small>" . $e->getMessage() . "</small>";
            $html = $this->getHtml($errorMsg, '#500000', '#ff4d4d'); // خلفية حمراء داكنة

            $listBatch[] = [
                'msgType' => 'ins_screen_html_document_write',
                'msgArg'  => $this->filterArgs([
                    'sHtml'   => $html,
                    'sInsPwd' => $sInsPwd
                ]),
            ];
        }

        // 8. الرد النهائي (دائماً 200 OK لتجنب تعليق الجهاز)
        return response()->json([
            'msgType' => 'ins_cloud_batch',
            'msgArg'  => [
                'bReply'    => true,
                'listBatch' => $listBatch,
            ],
        ]);
    }

    // دالة مساعدة لتنظيف HTML
    private function getHtml($message, $bgColor, $textColor)
    {
        // قمت بإزالة الصورة مؤقتاً لأن تحميل الصور الثقيلة قد يسبب تعليق الجهاز أحياناً
        // يمكنك إعادتها إذا كانت الصورة مخزنة محلياً داخل الجهاز وصغيرة جداً
        return <<<HTML
            <html>
              <body style="background-color:{$bgColor}; text-align:center; font-family:Arial, sans-serif; margin:0; padding-top:20px;">
                <h2 style="color:{$textColor}; font-size:26px;">{$message}</h2>
                <div id="id_dt_hhmm" style="color:#cccccc; margin-top:20px; font-size:20px;"></div>
              </body>
            </html>
HTML;
    }

    private function filterArgs($args)
    {
        return array_filter($args, fn($v) => $v !== null);
    }


    public function handle33(Request $request)
    {
        $event = $request->all();
        \Log::info('Kapri Event Received:', $event);

        // التحقق من الـ token
        if (($event['msgArg']['sToken'] ?? '') !== 'test-123456789') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $qrToken = $event['msgArg']['sData'] ?? null;

        if (!$qrToken) {
            return response()->json(['error' => 'QR token missing'], 400);
        }

        // جلب الـ QR وتحقق الصلاحية
        $hours = getSetting('qr_expiration_hours', 12);
        $qr = QrCode::where('qr_token', $qrToken)
            ->WhereRaw('TIMESTAMPADD(HOUR, ?, updated_at) > NOW()', [$hours])
            ->first();

        if (!$qr) {
            return response()->json(['error' => 'QR not valid or expired'], 401);
        }

        $user = $qr->user ?? null;

        // التحقق من الاشتراك والضيوف
        if (!is_null($user)) {
            if (is_null($user->current_subscription)) {
                return response()->json(['error' => 'Subscription Expired'], 401);
            }

            if ($qr->type == "visitor" && $qr->status == "pending") {
                $user->subscription->increment('used_guests');
                if ($user->subscription->last_guests_limit > 0) {
                    $user->subscription->decrement('last_guests_limit');
                }
                if ($user->subscription->last_guests_limit <= 0) {
                    return response()->json(['error' => 'QR not valid or expired'], 401);
                }
            }

            // سجّل الزيارة دائمًا
            $user->visitHistories()->create([]);

            // غيّر status بس لو لسّا pending
            if ($qr->status !== 'checked_in') {
                $qr->update(['status' => 'checked_in']);
            }
        }

        // إعداد الـ batch دائمًا (حل مشكلة التعليق)
        $listBatch = [];
        $sInsPwd = env('KAPRI_INS_PWD');

        if (($event['msgType'] ?? '') === 'on_uart_receive') {
            // 1. فتح الـ relay (باب) لـ 5 ثواني - دائمًا
            $listBatch[] = [
                'msgType' => 'ins_inout_relay_operate',
                'msgArg' => [
                    'sPosition' => 'main',
                    'sMode' => 'on',
                    'ucRelayNum' => 0,
                    'ucTime_ds' => 50, // 5 ثواني
                ]
            ];

            // 2. صوت البازر - دائمًا
            $listBatch[] = [
                'msgType' => 'ins_inout_buzzer_operate',
                'msgArg' => array_filter([
                    'sPosition' => 'main',
                    'sMode' => 'on',
                    'ucTime_ds' => 1,
                    'sInsPwd' => $sInsPwd,
                ], fn($v) => $v !== null),
            ];

            // 3. شاشة HTML حسب الحالة - دائمًا
            $statusText = ($qr->status == 'checked_in') ? "Welcome back" : "Welcome";
            $nameText = ($qr->type == "visitor" ? "Guest " : "") . ($user->name ?? "User");
            $welcome = $statusText . " " . $nameText;

            $html = <<<HTML
<html>
  <body style="background-color:#000; text-align:center; font-family:Arial, sans-serif;">
    <div style="margin-top:10px;">
      <img src="boot.jpg" width="160" style="margin-top:10px;"/>
      <h2 style="color:#333;">{$welcome}</h2>
      <div id="id_dt_hhmm" style="color:white; margin-top:5px; font-size:24px;"></div>
    </div>
  </body>
</html>
HTML;

            $listBatch[] = [
                'msgType' => 'ins_screen_html_document_write',
                'msgArg' => array_filter([
                    'sHtml' => $html,
                    'sInsPwd' => $sInsPwd,
                ], fn($v) => $v !== null),
            ];
        }

        // الـ response النهائي - دائمًا ins_cloud_batch مع listBatch مليان
        $response = [
            'msgType' => 'ins_cloud_batch',
            'msgArg' => [
                'bReply' => true,
                'listBatch' => $listBatch, // **ما يصير فارغ أبدًا**
            ],
        ];

        \Log::info('Kapri Response Sent:', $response);
        return response()->json($response);
    }






}
