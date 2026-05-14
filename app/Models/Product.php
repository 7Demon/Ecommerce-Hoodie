<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'Size',
        'stock',
        'price',
        'reserved_stock',
    ];
}
