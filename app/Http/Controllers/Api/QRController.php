<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QRCode;
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
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://192.168.0.248:9445/api/instruction', [
            "msgType" => "ins_inout_buzzer_operate",
            "msgArg" => [
                "sPosition" => "main",
                "sMode" => "on",
                "ucTime_ds" => 30
            ]
        ]);
        $data = $response->json(); // إذا كانت الاستجابة JSON
        return $data;
        $event = $request->json()->all();
            Log::info('QR Scan received - before type', [
                'event' => "test"
            ]);
        if (!empty($event['msgType']) && $event['msgType'] === 'on_uart_receive') {

            $token = $event['msgArg']['sData'] ?? null;

            $extraUid = $event['msgArg']['oExtra']['lblmgr']['uid'] ?? null;

            Log::info('QR Scan received', [
                'token' => $token,
                'extra_uid' => $extraUid
            ]);

        }

        return response()->json(['status' => 'denied']);
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
    }
}
