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
                $qr->update(['status' => 'checked_in']);
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

    private function respondWithError($message)
    {
        // شاشة حمراء للخطأ
        $html = $this->generateHtmlResponse("ACCESS DENIED<br><small>$message</small>", '#300000', '#e74c3c');

        $listBatch = [];

        // 1. صوت خطأ (3 نغمات متقطعة أو طويلة)
        $listBatch[] = [
            'msgType' => 'ins_inout_buzzer_operate',
            'msgArg'  => $this->filterArgs([
                'sPosition' => 'main',
                'sMode'     => 'beep_50', // نمط تنبيه
                'ucTime_ds' => 10, // 1 ثانية
            ]),
        ];

        // 2. عرض رسالة الخطأ
        $listBatch[] = [
            'msgType' => 'ins_screen_html_document_write',
            'msgArg'  => $this->filterArgs(['sHtml' => $html]),
        ];

        // ملاحظة: نرجع JSON صحيح للجهاز حتى لو كان خطأ، لكي ينفذ الأوامر
        return response()->json([
            'msgType' => 'ins_cloud_batch',
            'msgArg'  => ['bReply' => true, 'listBatch' => $listBatch],
        ]);
    }

    /**
     * تصميم شاشة HTML
     */
    private function generateHtmlResponse($message, $bgColor, $textColor)
    {
        return <<<HTML
        <html>
          <body style="background-color:{$bgColor}; text-align:center; font-family:Arial, sans-serif; padding-top: 20px;">
            <div style="border: 2px solid {$textColor}; padding: 10px; border-radius: 10px; margin: 10px;">
                <h2 style="color:{$textColor}; margin:0;">{$message}</h2>
            </div>
            <div id="id_dt_hhmm" style="color:white; margin-top:15px; font-size:20px;"></div>
          </body>
        </html>
HTML;
    }

    /**
     * فلترة المعاملات وإضافة كلمة المرور إن وجدت
     */
    private function filterArgs($args)
    {
        if ($this->insPwd) {
            $args['sInsPwd'] = $this->insPwd;
        }
        return $args;
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
//        return $returnBatch($listBatch);
//    }

    public function handle(Request $request)
    {
        $event = $request->all();
        \Log::debug('Kapri Event Received', $event);

        /* =========================
         |  Basic validation
         ========================= */
        if (($event['msgArg']['sToken'] ?? '') !== 'test-123456789') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (($event['msgType'] ?? '') !== 'on_uart_receive') {
            return $this->emptyBatch();
        }

        $qrToken  = $event['msgArg']['sData'] ?? null;
        $deviceId = $event['msgArg']['sEUI64'] ?? 'unknown';

        if (!$qrToken) {
            return $this->emptyBatch();
        }

        /* =========================
         |  Device LOCK (VERY IMPORTANT)
         ========================= */
        $deviceLockKey = 'kapri_device_lock_' . $deviceId;

        if (\Cache::has($deviceLockKey)) {
            return $this->emptyBatch(); // device busy
        }

        \Cache::put($deviceLockKey, true, now()->addSeconds(3));

        /* =========================
         |  QR validation
         ========================= */
        $hours = getSetting('qr_expiration_hours', 12);

        $qr = QrCode::where('qr_token', $qrToken)
            ->whereRaw('TIMESTAMPADD(HOUR, ?, updated_at) > NOW()', [$hours])
            ->first();

        if (!$qr || $qr->status === 'checked_in') {
            return $this->emptyBatch();
        }

        $user = $qr->user;
        if (!$user || is_null($user->current_subscription)) {
            return $this->emptyBatch();
        }

        /* =========================
         |  Visitor limits
         ========================= */
        if ($qr->type === 'visitor' && $qr->status === 'pending') {

            if ($user->subscription->last_guests_limit <= 0) {
                return $this->emptyBatch();
            }

            $user->subscription->increment('used_guests');
            $user->subscription->decrement('last_guests_limit');
        }

        /* =========================
         |  Update QR + history
         ========================= */
        $qr->update(['status' => 'checked_in']);
        $user->visitHistories()->create([]);

        /* =========================
         |  Build device commands
         ========================= */
        $sInsPwd = env('KAPRI_INS_PWD');

        $listBatch = [];

        // Relay (open door)
        $listBatch[] = [
            'msgType' => 'ins_inout_relay_operate',
            'msgArg'  => [
                'sPosition'  => 'main',
                'sMode'      => 'on',
                'ucRelayNum' => 0,
                'ucTime_ds'  => 50,
            ]
        ];

        // Buzzer (short beep)
        $listBatch[] = [
            'msgType' => 'ins_inout_buzzer_operate',
            'msgArg'  => array_filter([
                'sPosition' => 'main',
                'sMode'     => 'on',
                'ucTime_ds' => 1,
                'sInsPwd'   => $sInsPwd,
            ])
        ];

        // Screen HTML (ONLY ONCE)
        $welcome = 'Welcome ' . ($qr->type === 'visitor' ? 'Guest ' : '') . ($user->name ?? '');

        $html = <<<HTML
<html>
  <body style="background:#000; text-align:center; font-family:Arial;">
    <img src="boot.jpg" width="160" style="margin-top:10px"/>
    <h2 style="color:#fff;">{$welcome}</h2>
    <div id="id_dt_hhmm" style="color:white; font-size:24px;"></div>
  </body>
</html>
HTML;

        $listBatch[] = [
            'msgType' => 'ins_screen_html_document_write',
            'msgArg'  => array_filter([
                'sHtml'   => $html,
                'sInsPwd' => $sInsPwd,
            ])
        ];

        /* =========================
         |  Final response
         ========================= */
        return response()->json([
            'msgType' => 'ins_cloud_batch',
            'msgArg'  => [
                'bReply'    => true,
                'listBatch' => $listBatch,
            ],
        ]);
    }

    /* =========================
     |  Helper: empty batch
     ========================= */
    private function emptyBatch()
    {
        return response()->json([
            'msgType' => 'ins_cloud_batch',
            'msgArg'  => [
                'bReply'    => true,
                'listBatch' => [],
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
    } }
