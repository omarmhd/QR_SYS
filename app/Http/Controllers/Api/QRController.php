<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendRestoreScreenJob;
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
                'last_guests_limit' => $validated['guests_count']
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Guests limit updated successfully.',
                'data' => [
                    'last_guests_limit' => $validated['guests_count']
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
            ->WhereRaw('TIMESTAMPADD(HOUR, ?, updated_at) > NOW()', [$hours])
            ->first();


        if (!$qr) {
            return response()->json(['error' => 'QR not valid or expired'], 401);
        }
        $user=$qr->user;

        if ($user->subscription->last_guests_limit==0){
            return response()->json(['error' => 'QR not valid or expired'], 401);

        }

//        if(is_null($user->current_subscription)){
//            return response()->json(['error' => 'Subscription Expired'], 401);
//
//        }

        $updated=$qr->update(['status' => 'checked_in']);

        if($updated){
            $user->subscription->increment('used_guests');
            $user->subscription->decrement('last_guests_limit');
        }

        $user->visitHistories()->create([]);

        if ($qr->type=="visitor") {
            $user->subscription->increment('used_guests');
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
                    'sPosition' => 'main',   // ريليه الجهاز الرئيسي
                    'sMode'     => 'on',     // تشغيل (يمكن استخدام 'off' لإيقافه)
                    "ucRelayNum"=> 0,
                    'ucTime_ds' => 50,       // المدة (3 ثوانٍ)
                ]
            ];

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


                $restoreHtml = <<<HTML
            <html>
              <body style="background-color:#000; text-align:center; font-family:Arial, sans-serif;">
                <img src="boot.jpg" width="160" style="margin-top:40px;"/>
                <div id="id_dt_hhmm" style="color:white; margin-top:20px; font-size:24px;"></div>
              </body>
            </html>
HTML;
                SendRestoreScreenJob::dispatch($sInsPwd, $restoreHtml, "https://elunicolounge.com/api/kapri/event")
                    ->delay(now()->addSeconds(10));
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

        sleep(3);
        $listBatch[] = [
            'msgType' => 'ins_screen_html_document_write',
            'msgArg' => [
                'sHtml'   => "<img src='boot.jpg'>"
            ]
        ];
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
