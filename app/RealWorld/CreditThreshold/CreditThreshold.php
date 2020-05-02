<?php

namespace App\RealWorld\CreditThreshold;

use App\Notifications\UserCreditIsLowNotification;
use App\User;
use Notification;
use App\Jobs\ExpireAccountJob;
use Carbon\Carbon;

trait CreditThreshold {

    /**
     * Send Email if Users Credit Is Lower Than Credit Threshold defined by Authority!
     *
     * @param User $user
     * @return void
     */
    public function checkUserCreditThreshold(User $user)
    {
        $user_balance = $user->transactionsBalance->balance;
        if($user_balance > 0 &&  $user_balance < config('credits.user_credit_threshold')) {
            Notification::send($user, new UserCreditIsLowNotification());
        }else if($user_balance < 0) {
            ExpireAccountJob::dispatch($user)->delay(Carbon::now()->addHours(config('credits.expiration_time_in_hours_for_delete_all_users_data')));
        }
    }
}