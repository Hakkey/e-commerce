<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'order_id', 'payment_method',  'status',  'paid_amount_cents'
    ];
}
