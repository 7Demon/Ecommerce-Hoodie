<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    //
    protected $fillable = [
        'order_id',
        'payment_method',
        'payment_status',
        'transaction_id',
    ];
}
