<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'gateway_provider',
        'gateway_reference',
        'payment_method',
        'payment_url',
        'snap_token',
        'amount',
        'status',
        'payload',
        'paid_at',
        'expired_at',
        'failed_at',
    ];

    protected function casts(): array
    {
        return [
            'amount'     => 'decimal:2',
            'payload'    => 'array',
            'paid_at'    => 'datetime',
            'expired_at' => 'datetime',
            'failed_at'  => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
