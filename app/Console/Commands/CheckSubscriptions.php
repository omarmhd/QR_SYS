<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Services\FcmNotificationService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CheckSubscriptions extends Command
{

    protected $signature = 'app:check-subscriptions';

    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    protected $fcmNotificationService;

    public function __construct(FcmNotificationService $fcmNotificationService)
    {
        parent::__construct();
        $this->fcmNotificationService = $fcmNotificationService;
    }

    public function handle()
    {
        $today = Carbon::today();

        $subscriptions = Subscription::with("user")->where('status', 'active')->get();

        foreach ($subscriptions as $sub) {
            $endDate = Carbon::parse($sub->end_date);
            $daysLeft = $today->diffInDays($endDate, false);

            if ($daysLeft === 5 && !$sub->reminder_sent) {
                $this->sendNotification($sub, 'reminder');
                $sub->update(['reminder_sent' => true]);
            }

            if ($today->greaterThanOrEqualTo($endDate)) {
                $sub->update(['status' => 'expired']);
//                $this->sendNotification($sub, 'expired');
                $sub->user->update(["current_subscription"=>null,"subscription_status"=>0]);
            }
        }

        $this->info('✅ Subscription reminders and expirations processed successfully.');
    }

    private function sendNotification($subscription, $type)
    {
        $user = $subscription->user;
        $tokens = $user->deviceTokens->pluck('fcm_token')->filter()->toArray();

        if (!$tokens) return;

        if ($type === 'reminder') {
            $title = '🔔 Reminder: Subscription expiring soon';
            $body = "Your subscription will expire in 5 days (on "
                . Carbon::parse($subscription->end_date)->format('F j, Y') . ").";
            $dataType = 'subscription_reminder';
        } else {
            $title = '❌ Subscription Expired';
            $body = "Your subscription has ended. Please renew to continue using the service.";
            $dataType = 'subscription_expired';
        }

        $this->fcmNotificationService->sendNotification(
            $tokens,
            $title,
            $body,
            ['type' => $dataType],
            null,
            'tokens',
            $user->id
        );
    }
}
