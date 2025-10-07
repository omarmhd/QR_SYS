<?php
namespace App\Services;

use App\Models\User;

Class UsageCheckerService{

    public function canUseVisitOrInvite(User $user){
        $subscription=$user->subscription;
        if (!$subscription){

            return [
                'allowed' => false,
                'message' => 'No active subscription found for this user.'
            ];

        }
        $max_limit=$user->plan->guest_passes_per_year;
        $used_guests=$subscription->used_guests;

        if ($used_guests >=$max_limit) {
            return [
                'allowed' => false,
                'message' => 'You have exceeded the allowed number of guests for this subscription.'
            ];
        }



    }
}
