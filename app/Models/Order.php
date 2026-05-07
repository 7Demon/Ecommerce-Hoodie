<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'customer_address',
        'subtotal',
        'shipping_cost',
        'discount',
        'tax',
        'total_price',
        'status',
    ];
}
