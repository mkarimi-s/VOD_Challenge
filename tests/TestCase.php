<?php

namespace Tests;

use App\Jobs\AddCreditToUserForSignUp;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $loggedInUser;

    protected $user;

    protected $headers;

    public function setUp()
    {
        parent::setUp();

        $users = factory(\App\User::class)->times(2)->create();

        foreach($users as $user) {
            dispatch(new AddCreditToUserForSignUp($user));
        }

        $this->loggedInUser = $users[0];

        $this->user = $users[1];

        $this->headers = [
            'Authorization' => "Token {$this->loggedInUser->token}"
        ];
    }
}
