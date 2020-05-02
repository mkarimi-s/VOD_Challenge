<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\User;
use Log;

class ExpireAccountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    private $_user;

    /**
     * ExpireAccount constructor.
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
        Log::info(sprintf('start to delete all data of user %s with id %s', $this->_user->username, (string) $this->_user->id));
        $this->_user->comments()->delete();
        Log::info('comments deleted');

        $this->_user->articles()->delete();
        Log::info('articles deleted');

        $this->_user->favorites()->detach();
        Log::info('favorites deleted');

        $this->_user->notifications()->delete();
        Log::info('notifications deleted');

        $this->_user->following()->detach();
        Log::info('followings deleted');
    }
}
