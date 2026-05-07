<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order_item extends Model
{
    //
    protected $fillable =[ 
        'order_id',
        'product_id',
        'price',
        'quantity',
        'total_price',
    ];
}
