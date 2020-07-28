<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $primaryKey = 'id';

    protected $fillable = [
        'item_id', 'order_id', 'cost_per_item',  'product_name',  'quantity'
    ];

    public function order(){
        return $this->belongsTo('App\Order');
    }
}
