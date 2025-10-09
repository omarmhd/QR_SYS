<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QRCode;
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

            // 3 sec buzzer
            $buzzer = [
                'msgType' => 'ins_inout_buzzer_operate',
                'msgArg'  => array_filter([
                    'sPosition' => 'main',
                    'sMode'     => 'on',     // or 'beep_50'
                    'ucTime_ds' => 30,       // 3.0 s
                    'sInsPwd'   => $sInsPwd, // include only if set
                ], fn($v) => $v !== null),
            ];

            $listBatch[] = [
                'msgType' => 'ins_inout_relay_operate',
                'msgArg'  => array_filter([
                    'relay_id' => 1,
                    'time_ms'  => 5000
                ], fn($v) => $v !== null),
            ];
            ;
//            $listBatch[] = $buzzer;

            // (Optional) show QR data
            if (!empty($event['msgArg']['sData'])) {
                $safe = e($event['msgArg']['sData']);
                $html = "<html><body><h2>welcome {$user->name} : {$safe}</h2></body></html>";
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
