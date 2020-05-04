<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\User;
use Illuminate\Support\Facades\DB;

class AddCreditToUserForSignUp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    private $_user;

    /**
     * AddCreditToUserForSignUp constructor.
     * @param User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->_user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::transaction(function (){
            $this->_user->charge(config('credits.sign_up_credit'),[
                'user_id' => $this->_user->id,
                'transactionable_type' => User::class,
                'transactionable_id' => $this->_user->id,
                'description' => config('credits.sign_up_description')
            ]);
        });
        Log::info(sprintf('adding %d credit to user with id %d', config('credits.sign_up_credit'), $this->_user->id));
    }
}
