<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Services\Payment\MidtransGateway;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    protected CartService $cartService;
    protected MidtransGateway $gateway;

    public function __construct(CartService $cartService, MidtransGateway $gateway)
    {
        $this->cartService = $cartService;
        $this->gateway     = $gateway;
    }

    /**
     * Process the checkout: validate stock, create order, create payment, clear cart.
     *
     * @return array{order: Order, snap_token: string|null, payment_url: string|null}
     */
    public function process(array $customerData): array
    {
        $cartItems = $this->cartService->getCart();

        if (empty($cartItems)) {
            throw new \RuntimeException('Keranjang belanja kosong.');
        }

        return DB::transaction(function () use ($cartItems, $customerData) {

            // 1. Validate stock & lock rows
            foreach ($cartItems as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);

                if (!$product) {
                    throw new \RuntimeException("Produk \"{$item['name']}\" tidak ditemukan.");
                }

                $available = $product->stock - $product->reserved_stock;
                if ($available < $item['qty']) {
                    throw new \RuntimeException(
                        "Stok \"{$product->name}\" tidak mencukupi. Tersedia: {$available}, diminta: {$item['qty']}."
                    );
                }
            }

            // 2. Calculate totals
            $subtotal     = $this->cartService->getSubtotal();
            $shippingCost = (float) config('shop.shipping_flat_rate', 0);
            $discount     = 0;
            $tax          = 0;
            $totalPrice   = $subtotal + $shippingCost - $discount + $tax;

            // 3. Create Order
            $order = Order::create([
                'order_number'     => Order::generateOrderNumber(),
                'user_id'          => auth()->id(),  // null for guest
                'customer_name'    => $customerData['customer_name'],
                'customer_email'   => $customerData['customer_email'],
                'shipping_address' => $customerData['shipping_address'],
                'subtotal'         => $subtotal,
                'shipping_cost'    => $shippingCost,
                'discount'         => $discount,
                'tax'              => $tax,
                'total_price'      => $totalPrice,
                'status'           => 'pending',
            ]);

            // 4. Create Order Items + reserve stock
            foreach ($cartItems as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);

                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $product->id,
                    'product_name'  => $product->name,
                    'product_size'  => $item['size'] ?? null,
                    'product_color' => $item['color'] ?? null,
                    'price'         => $product->price,
                    'quantity'      => $item['qty'],
                    'total_price'   => $product->price * $item['qty'],
                ]);

                // Reserve stock
                $product->increment('reserved_stock', $item['qty']);
            }

            // 5. Create Payment record
            $payment = Payment::create([
                'order_id'         => $order->id,
                'gateway_provider' => 'midtrans',
                'payment_method'   => 'snap',
                'amount'           => $totalPrice,
                'status'           => 'pending',
            ]);

            // 6. Create Midtrans Snap transaction
            $order->load('items');
            $snapResult = $this->gateway->createTransaction($order, $payment);

            $payment->update([
                'snap_token'  => $snapResult['snap_token'] ?? null,
                'payment_url' => $snapResult['payment_url'] ?? null,
            ]);

            // 7. Clear cart
            $this->cartService->clear();

            return [
                'order'       => $order,
                'snap_token'  => $snapResult['snap_token'] ?? null,
                'payment_url' => $snapResult['payment_url'] ?? null,
            ];
        });
    }
}
