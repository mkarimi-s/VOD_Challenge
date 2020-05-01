<?php


namespace App\RealWorld\Billable;

use App\RealWorld\Models\Transaction;
use App\RealWorld\Models\TransactionBalance;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

trait Billable
{

    /**
     * Make a "one off" charge on the customer for the given amount.
     *
     * @param int $amount
     * @param array $options
     * @return \Stripe\Charge
     * @throws \InvalidArgumentException
     */
    public function charge($amount, array $options = [])
    {
        $params = array_merge([
            'amount' => $amount,
        ], $options);

        $output = Transaction::create($params);

        return $output;
    }

    /**
     * @return HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function transactionsBalance()
    {
        return $this->hasOne(TransactionBalance::class, 'user_id' , 'id');
    }

    /**
     * @return MorphTo
     */
    public function transactionable()
    {
        return $this->morphTo();
    }
}

