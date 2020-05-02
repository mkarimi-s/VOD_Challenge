<?php

declare(strict_types=1);

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Check if Users Credit Balance is not Negative
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->transactionsBalance->balance > 0 ;
    }
}
