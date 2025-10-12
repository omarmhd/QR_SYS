<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QRCode;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class QRController extends Controller
{

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

        if ($user->subscription) {
            $user->subscription->update([
                'last_visit_guests_limit' => $validated['guests_count']
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Guests limit updated successfully.',
                'data' => [
                    'last_visit_guests_limit' => $validated['guests_count']
                ]
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'No subscription found for this user.'
        ], 404);
    }





    public function handle(Request $request)
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
            ->where('status', 'pending')
            ->WhereRaw('TIMESTAMPADD(HOUR, ?, created_at) > NOW()', [$hours])
            ->first();


        if (!$qr) {
            return response()->json(['error' => 'QR not valid or expired'], 401);
        }
        $user=$qr->user;
//        if(is_null($user->current_subscription)){
//            return response()->json(['error' => 'Subscription Expired'], 401);
//
//        }

        $qr->update(['status' => 'checked_in']);
        $user->visitHistories()->create([]);

        $listBatch = [];

        if (($event['msgType'] ?? '') === 'on_uart_receive') {

            // If you configured an instruction password on the device (interface_ins_pwd),
        //  you MUST include it in each instruction's msgArg as "sInsPwd": "<your_password>".
//  Remove the line if you didn’t set that parameter.
            $sInsPwd = env('KAPRI_INS_PWD'); // or null if not used
            $imageUrl = 'https://elunicolounge.com/logo_white.png';
            $imagePath = storage_path('app/public/logo_white.png');

            // تحميل الصورة محليًا لتفادي مشاكل الاتصال الخارجي
            if (!file_exists($imagePath)) {
                try {
                    file_put_contents($imagePath, file_get_contents($imageUrl));
                } catch (\Exception $e) {
                    \Log::error('Failed to download logo: ' . $e->getMessage());
                }
            }


            $listBatch[] = [
                'msgType' => 'ins_screen_image_store',
                'msgArg'  => [
                    'sImgName' => 'boot.jpg',
                    'sImgB64'  => base64_encode(file_get_contents($imagePath)),
                ],
            ];

            // ✅ عرض صفحة HTML على الشاشة
            $listBatch[] = [
                'msgType' => 'ins_screen_html_document_write',
                'msgArg'  => [
                    'sHtml' => "
                    <html>
                      <body style='margin:0;background-color:black;text-align:center;'>
                        <img src='boot.jpg' width='160' style='margin-top:40px;'/>
                        <div id='id_dt_hhmm' style='color:white;font-size:24px;'></div>
                        <div id='id_dt_ddmmyyyy' style='color:gray;font-size:18px;'></div>
                      </body>
                    </html>",
                ],
            ];
            // 3 sec buzzer
            $listBatch[] = [
                'msgType' => 'ins_inout_relay_operate',
                'msgArg'  => [
                    'sPosition' => 'main',   // ريليه الجهاز الرئيسي
                    'sMode'     => 'on',     // تشغيل (يمكن استخدام 'off' لإيقافه)
                    "ucRelayNum"=> 0,
                    'ucTime_ds' => 50,       // المدة (3 ثوانٍ)
                ]
            ];

// تشغيل البازر (الصافرة)
            $buzzer = [
                'msgType' => 'ins_inout_buzzer_operate',
                'msgArg'  => array_filter([
                    'sPosition' => 'main',
                    'sMode'     => 'on',     // أو 'beep_50' لنبضات متقطعة
                    'ucTime_ds' => 1,       // 3.0 ثوانٍ
                    'sInsPwd'   => $sInsPwd, // فقط لو عندك كلمة مرور للأوامر
                ], fn($v) => $v !== null),
            ];

            $listBatch[] = $buzzer;



            // (Optional) show QR data
            if (!empty($event['msgArg']['sData'])) {
                $safe = e($event['msgArg']['sData']);
                $html = <<<HTML
            <html>
              <body style="background-color:#000; text-align:center; font-family:Arial, sans-serif;">
                <div style="margin-top:40px;">
                  <img src="https://elunicolounge.com/logo_white.png" alt="Elunico Logo" style="width:150px; height:auto; margin-bottom:20px;">
                  <h2 style="color:#333;">Welcome {$user->name}</h2>
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
            }
        }

// Always return a valid ins_cloud_batch
        $response = [
            'msgType' => 'ins_cloud_batch',
            'msgArg'  => [
                'bReply'    => true,       // ask Kapri to POST back ans_cloud_batch
                'listBatch' => $listBatch, // a list (can be empty)
            ],
        ];

        return response()->json($response);
    }
    private function openGate()
    {
        $deviceIp = "192.168.1.100";
        $url = "http://{$deviceIp}:9445/api/instruction";

        $instruction = [
            "msgType" => "ins_inout_relay_switch_on",
            "msgArg" => [
                "relay" => 0,      // رقم الريليه (0,1,2)
                "time"  => 5000    // وقت التشغيل بالمللي ثانية (5 ثواني)
            ]
        ];

        Http::post($url, $instruction);
    } }
