<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    private string $sessionKey = 'cart';

    /**
     * Dapatkan semua item di keranjang.
     */
    public function getCart(): array
    {
        return Session::get($this->sessionKey, []);
    }

    /**
     * Tambahkan item ke keranjang.
     */
    public function add(int $productId, int $qty, ?string $size, ?string $color): void
    {
        $cart = $this->getCart();
        
        $product = Product::findOrFail($productId);

        // Buat unique ID berdasarkan product_id dan variasi agar bisa dibedakan.
        $cartId = $productId . '-' . ($size ?? 'none') . '-' . ($color ?? 'none');

        if (isset($cart[$cartId])) {
            $cart[$cartId]['qty'] += $qty;
        } else {
            $cart[$cartId] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'size' => $size,
                'color' => $color,
                'qty' => $qty,
            ];
        }

        Session::put($this->sessionKey, $cart);
    }

    /**
     * Ubah kuantitas item.
     */
    public function update(string $cartId, int $qty): void
    {
        $cart = $this->getCart();

        if (isset($cart[$cartId])) {
            if ($qty > 0) {
                $cart[$cartId]['qty'] = $qty;
            } else {
                unset($cart[$cartId]);
            }
            Session::put($this->sessionKey, $cart);
        }
    }

    /**
     * Hapus item dari keranjang.
     */
    public function remove(string $cartId): void
    {
        $cart = $this->getCart();

        if (isset($cart[$cartId])) {
            unset($cart[$cartId]);
            Session::put($this->sessionKey, $cart);
        }
    }

    /**
     * Dapatkan total harga keranjang.
     */
    public function getSubtotal(): float
    {
        $cart = $this->getCart();
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        return $total;
    }

    /**
     * Total item unik di keranjang.
     */
    public function count(): int
    {
        return array_sum(array_column($this->getCart(), 'qty'));
    }

    /**
     * Kosongkan keranjang.
     */
    public function clear(): void
    {
        Session::forget($this->sessionKey);
    }
}
