<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'reference_no', 'tax',  'service_charge',  'total_amount_cents',  'is_walkin', 'status'
    ];

    public function orderitems(){
        return $this->hasMany('App\OrderItem');
    }

    public function transaction(){
        return $this->hasOne('App\Transaction');
    }


}
