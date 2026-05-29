<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderStatusService
{
    /**
     * Valid status transitions.
     */
    private array $transitions = [
        'pending'   => ['paid', 'cancelled'],
        'paid'      => ['shipped', 'cancelled'],
        'shipped'   => ['delivered'],
        'delivered' => [],
        'cancelled' => [],
    ];

    /**
     * Check if transition is valid.
     */
    public function canTransition(string $from, string $to): bool
    {
        return in_array($to, $this->transitions[$from] ?? []);
    }

    /**
     * Mark order as paid (called from webhook when payment succeeds).
     * Permanently deduct stock and release reserved_stock.
     */
    public function markAsPaid(Order $order): void
    {
        if ($order->status !== 'pending') {
            return;
        }

        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                $product = Product::lockForUpdate()->find($item->product_id);
                if ($product) {
                    $product->decrement('stock', $item->quantity);
                    $product->decrement('reserved_stock', $item->quantity);
                }
            }

            $order->update([
                'status'  => 'paid',
                'paid_at' => now(),
            ]);

            $order->payment?->update([
                'status'  => 'completed',
                'paid_at' => now(),
            ]);
        });
    }

    /**
     * Mark order as shipped with tracking info.
     */
    public function markAsShipped(Order $order, ?string $courier = null, ?string $service = null, ?string $trackingNumber = null): void
    {
        if (!$this->canTransition($order->status, 'shipped')) {
            throw new \RuntimeException("Cannot transition from '{$order->status}' to 'shipped'.");
        }

        $order->update([
            'status'           => 'shipped',
            'shipping_courier' => $courier,
            'shipping_service' => $service,
            'tracking_number'  => $trackingNumber,
            'shipped_at'       => now(),
        ]);
    }

    /**
     * Mark order as delivered.
     */
    public function markAsDelivered(Order $order): void
    {
        if (!$this->canTransition($order->status, 'delivered')) {
            throw new \RuntimeException("Cannot transition from '{$order->status}' to 'delivered'.");
        }

        $order->update([
            'status'       => 'delivered',
            'delivered_at' => now(),
        ]);
    }

    /**
     * Cancel an order. Release reserved stock if payment was still pending.
     */
    public function cancel(Order $order): void
    {
        if (!$this->canTransition($order->status, 'cancelled')) {
            throw new \RuntimeException("Cannot cancel order with status '{$order->status}'.");
        }

        DB::transaction(function () use ($order) {
            // Release reserved stock only if order was still pending (not yet paid)
            if ($order->status === 'pending') {
                foreach ($order->items as $item) {
                    $product = Product::lockForUpdate()->find($item->product_id);
                    if ($product) {
                        $product->decrement('reserved_stock', $item->quantity);
                    }
                }
            }

            $order->update([
                'status'       => 'cancelled',
                'cancelled_at' => now(),
            ]);

            $order->payment?->update([
                'status'    => 'cancelled',
                'failed_at' => now(),
            ]);
        });
    }

    /**
     * Handle payment failure/expiry. Release reserved stock.
     */
    public function handlePaymentFailed(Order $order, string $failureType = 'failed'): void
    {
        if ($order->status !== 'pending') {
            return;
        }

        DB::transaction(function () use ($order, $failureType) {
            foreach ($order->items as $item) {
                $product = Product::lockForUpdate()->find($item->product_id);
                if ($product) {
                    $product->decrement('reserved_stock', $item->quantity);
                }
            }

            $order->update([
                'status'       => 'cancelled',
                'cancelled_at' => now(),
            ]);

            $timestampField = $failureType === 'expired' ? 'expired_at' : 'failed_at';
            $order->payment?->update([
                'status'         => $failureType,
                $timestampField  => now(),
            ]);
        });
    }
}
