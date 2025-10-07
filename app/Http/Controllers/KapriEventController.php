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
        $event = $request->all();
        \Log::info('Kapri Event Received:', $event);

// 1) Token check
        if (($event['msgArg']['sToken'] ?? '') !== 'test-123456789') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

// 2) Build a proper ins_cloud_batch reply
        $listBatch = [];

        // Trigger on QR scans (UART)
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
            $listBatch[] = $buzzer;

            // (Optional) show QR data
            if (!empty($event['msgArg']['sData'])) {
                $safe = e($event['msgArg']['sData']);
                $html = "<html><body><h2>welcome omar : {$safe}</h2></body></html>";
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
    }
}
