<?php

namespace App\Listeners;

use App\Comment;
use App\Event\CommentCreated;
use App\RealWorld\CreditThreshold\CreditThreshold;
use DB;
use Notification;
use Log;

class DecreaseCreditAfterStoringComment
{
    use CreditThreshold;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  CommentCreated  $event
     * @return void
     */
    public function handle(CommentCreated $event)
    {
        DB::transaction(function() use ($event): void{
            $event->comment->user->charge(config('credits.comment_register_cost'),[
                'user_id' => $event->comment->user->id,
                'transactionable_type' => Comment::class,
                'transactionable_id' => $event->comment->id,
                'description' => config('credits.comment_register_description')
            ]);
        });

        $this->checkUserCreditThreshold($event->comment->user);
    }
}
