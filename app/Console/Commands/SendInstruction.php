<?php

namespace App\Console\Commands;

use App\Services\KapriService;
use Illuminate\Console\Command;

class SendInstruction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-instruction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(KapriService $kapri)
    {
        $kapri->listen();
    }
}
