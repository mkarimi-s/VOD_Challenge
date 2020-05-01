<?php

namespace App\Events;

use App\Article;
use Illuminate\Queue\SerializesModels;

class ArticleCreated
{
    use SerializesModels;

    /**
     * @var Article
     */
    public $article;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }
}
