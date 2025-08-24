<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KapriEventController extends Controller
{
    public function handle(Request $request)
    {
        $event = $request->json()->all();
        Log::info('QR Scan received',"before type");

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
