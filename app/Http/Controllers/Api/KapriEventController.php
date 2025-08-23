<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KapriEventController extends Controller
{
    public function handle(Request $request)
    {
        $event = $request->json()->all();

        if ($event['msgType'] === 'on_qr_read') {
            $token = $event['msgArg']['data'] ?? null;

            if ($token && $order = Order::where('qr_token', $token)->where('used', false)->first()) {
                $order->update(['used' => true]);

                $this->openGate();

                return response()->json(['status' => 'success', 'action' => 'gate opened']);
            }
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
