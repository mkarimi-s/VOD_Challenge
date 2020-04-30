<?php

namespace App\RealWorld\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['user_id', 'amount', 'transactionable_type' , 'transactionable_id', 'description'];
}
