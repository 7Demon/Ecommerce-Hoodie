<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'shipping_address',
        'subtotal',
        'shipping_cost',
        'discount',
        'tax',
        'total_price',
        'status',
        'shipping_courier',
        'shipping_service',
        'tracking_number',
        'paid_at',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal'     => 'decimal:2',
            'shipping_cost'=> 'decimal:2',
            'discount'     => 'decimal:2',
            'tax'          => 'decimal:2',
            'total_price'  => 'decimal:2',
            'paid_at'      => 'datetime',
            'shipped_at'   => 'datetime',
            'delivered_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    // ─── Relationships ─────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    // ─── Helpers ───────────────────────────────────────────────────────

    /**
     * Generate a unique order number: ORD-YYYYMMDD-XXXXX
     */
    public static function generateOrderNumber(): string
    {
        $date  = now()->format('Ymd');
        $rand  = strtoupper(substr(uniqid(), -5));
        $number = "ORD-{$date}-{$rand}";

        // Ensure uniqueness
        while (self::where('order_number', $number)->exists()) {
            $rand   = strtoupper(substr(uniqid(), -5));
            $number = "ORD-{$date}-{$rand}";
        }

        return $number;
    }
}
