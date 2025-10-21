<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        // ضع هنا الكوماند الخاص بك
        \App\Console\Commands\CheckSubscriptions::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('subscriptions:check')->daily();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
