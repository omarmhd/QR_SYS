<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class KapriService
{
    protected string $ip;
    protected string $eventUrl;
    protected string $insUrl;
    protected string $pwd;
    protected int $resetDelay;
    protected array $cards;
    protected array $qrcodes;

    public function __construct()
    {
        $this->ip = config('kapri.ip');
        $this->eventUrl = "http://{$this->ip}:9445/api/event";
        $this->insUrl   = "http://{$this->ip}:9445/api/instruction";
        $this->pwd      = config('kapri.instruction_password');
        $this->resetDelay = config('kapri.reset_delay_sec');
        $this->cards    = config('kapri.cards');
        $this->qrcodes  = config('kapri.qrcodes');
    }

    protected function addPwd(array $args): array
    {
        if ($this->pwd) {
            $args['sInsPwd'] = $this->pwd;
        }
        return $args;
    }

    public function sendIns(string $msgType, array $msgArg = [])
    {
        $payload = [
            'msgType' => $msgType,
            'msgArg'  => $this->addPwd($msgArg),
        ];

        $res = Http::timeout(5)->post($this->insUrl, $payload);
        $res->throw();
        return $res->json();
    }

    public function showMessage(string $text, string $color, string $symbol = '')
    {
        $html = <<<HTML
        <html><head><meta charset="utf-8"><style>
        body{margin:0;padding:0;width:320px;height:240px;display:flex;
             align-items:center;justify-content:center;background:#000;
             color:$color;font-family:Arial,Helvetica,sans-serif;
             font-size:26px;font-weight:800;text-align:center}
        </style></head><body>$symbol $text</body></html>
        HTML;

        return $this->sendIns("ins_screen_html_document_write", [
            "sPosition" => "main",
            "sHtml" => $html,
        ]);
    }

    public function showMainScreen()
    {
        $html = <<<HTML
        <html><head><meta charset="utf-8"><style>
        body{margin:0;padding:0;width:320px;height:240px;display:flex;
             align-items:center;justify-content:center;background:#000;
             color:#00E5FF;font-family:Arial,Helvetica,sans-serif;
             font-size:22px;font-weight:bold;text-align:center}
        </style></head><body>Welcome to Elunico VIP</body></html>
        HTML;

        return $this->sendIns("ins_screen_html_document_write", [
            "sPosition" => "main",
            "sHtml" => $html,
        ]);
    }

    public function buzzerOn(int $timeDs = 30)
    {
        return $this->sendIns("ins_inout_buzzer_operate", [
            "sPosition" => "main",
            "sMode" => "on",
            "ucTime_ds" => $timeDs,
        ]);
    }

    public function relayOn(int $relayNum = 0, int $timeDs = 30)
    {
        return $this->sendIns("ins_inout_relay_operate", [
            "sPosition" => "main",
            "ucRelayNum" => $relayNum,
            "ucTime_ds" => $timeDs,
        ]);
    }

    public function handleCard(array $event)
    {
        $track = $event['msgArg']['sTrack'] ?? '';
        $uid = strtoupper(substr($track, -8));

        if (isset($this->cards[$uid])) {
            $this->showMessage("ACCESS ALLOWED", "#00C853", "✔");
            $this->relayOn();
            echo "✅ Allowed card {$this->cards[$uid]}\n";
        } else {
            $this->showMessage("ACCESS DENIED", "#FF1744", "✖");
            $this->buzzerOn();
            echo "❌ Unknown card\n";
        }
    }

    public function handleQr(array $event)
    {
        $data = $event['msgArg']['sData'] ?? $event['msgArg']['sTrack'] ?? '';

        if (isset($this->qrcodes[$data])) {
            $this->showMessage("ACCESS ALLOWED", "#00C853", "✔");
            $this->relayOn();
            echo "✅ Allowed QR {$this->qrcodes[$data]}\n";
        } else {
            $this->showMessage("ACCESS DENIED", "#FF1744", "✖");
            $this->buzzerOn();
            echo "❌ Unknown QR\n";
        }
    }

    public function listen()
    {
        $this->showMainScreen();
        echo "📡 Listening on {$this->eventUrl}\n";

        while (true) {
            try {
                $res = Http::timeout(30)->get($this->eventUrl);
                if (!$res->ok()) {
                    echo "⚠ Event HTTP {$res->status()}: {$res->body()}\n";
                    sleep(1);
                    continue;
                }

                $ev = $res->json();
                $type = $ev['msgType'] ?? '';

                if ($type === 'on_mifare_track') {
                    $this->handleCard($ev);
                } elseif (in_array($type, ['on_qrcode_read', 'on_barcode_track', 'on_uart_receive'])) {
                    $this->handleQr($ev);
                } elseif ($type === 'event_queue_empty') {
                    continue;
                } else {
                    echo "📥 Other event: " . json_encode($ev) . "\n";
                }
            } catch (\Throwable $e) {
                echo "⚠ Loop error: {$e->getMessage()}\n";
                sleep(1);
            }
        }
    }
}
