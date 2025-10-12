<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendRestoreScreenJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sInsPwd;
    protected $restoreHtml;
    protected $deviceUrl;

    /**
     * Create a new job instance.
     */
    public function __construct($sInsPwd, $restoreHtml, $deviceUrl)
    {
        $this->sInsPwd = $sInsPwd;
        $this->restoreHtml = $restoreHtml;
        $this->deviceUrl = $deviceUrl;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $listBatch = [[
            'msgType' => 'ins_screen_html_document_write',
            'msgArg'  => array_filter([
                'sHtml'      => $this->restoreHtml,
                'sInsPwd'    => $this->sInsPwd], fn($v) => $v !== null),
        ]];

        $response = [
            'msgType' => 'ins_cloud_batch',
            'msgArg'  => [
                'bReply'    => true,
                'listBatch' => $listBatch,
            ],
        ];

        Http::post($this->deviceUrl, $response);

        \Log::info('Restore screen sent to Kapri device', [
            'deviceUrl' => $this->deviceUrl,
            'response' => $response
        ]);
    }
}
