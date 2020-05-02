<?php
declare(strict_types=1);

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

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
