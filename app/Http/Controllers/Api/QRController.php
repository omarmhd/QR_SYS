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
