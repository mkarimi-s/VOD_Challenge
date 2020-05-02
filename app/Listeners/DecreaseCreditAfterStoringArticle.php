<?php

namespace App\Listeners;

use App\Article;
use App\Events\ArticleCreated;
use App\RealWorld\CreditThreshold\CreditThreshold;
use DB;

class DecreaseCreditAfterStoringArticle
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
     * @param  ArticleCreated  $event
     * @return void
     */
    public function handle(ArticleCreated $event)
    {
        DB::transaction(function() use ($event): void{
            $event->article->user->charge(config('credits.article_register_cost'),[
                'user_id' => $event->article->user->id,
                'transactionable_type' => Article::class,
                'transactionable_id' => $event->article->id,
                'description' => config('credits.article_register_description')
            ]);
        });

        $this->checkUserCreditThreshold($event->article->user);
    }
}
