<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $primaryKey = 'id';

    protected $fillable = [
        'reference_no', 'tax',  'service_charge',  'total_amount_cents',  'is_walkin', 'status'
    ];


}
