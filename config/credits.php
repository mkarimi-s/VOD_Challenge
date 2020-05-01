<?php

return [
    'sign_up_credit' => env('SIGN_UP_CREDIT', 100000),
    'sign_up_description' => 'adding 100000 IRT for user registration',
    'article_register_cost' => env('ARTICLE_REGISTER_COST', -5000),
    'article_register_description' => 'decrease -5000 IRT for register an article',
    'number_of_free_comment' => env('NUMBER_OF_FREE_COMMENT', 5),
    'comment_register_cost' => env('COMMENT_REGISTER_COST', -5000),
    'comment_register_description' => 'decrease -5000 IRT for register a comment',
];
