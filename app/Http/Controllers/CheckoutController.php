<?php

namespace App\Http\Controllers;

use App\Services\CheckoutService;
use App\Services\Payment\MidtransGateway;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected CheckoutService $checkoutService;
    protected MidtransGateway $gateway;

    public function __construct(CheckoutService $checkoutService, MidtransGateway $gateway)
    {
        $this->checkoutService = $checkoutService;
        $this->gateway         = $gateway;
    }

    /**
     * Show the checkout form.
     */
    public function show(Request $request)
    {
        $cartService = app(\App\Services\CartService::class);
        $cartItems   = $cartService->getCart();

        if (empty($cartItems)) {
            return redirect()->route('shopping-cart')
                ->with('error', 'Keranjang Anda kosong. Tambahkan produk terlebih dahulu.');
        }

        $subtotal     = $cartService->getSubtotal();
        $shippingCost = (float) config('shop.shipping_flat_rate', 0);
        $total        = $subtotal + $shippingCost;

        // Pre-fill from auth user if logged in
        $user = $request->user();

        return view('pages.checkout', compact(
            'cartItems', 'subtotal', 'shippingCost', 'total', 'user'
        ));
    }

    /**
     * Process the checkout.
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'customer_name'    => ['required', 'string', 'max:255'],
            'customer_email'   => ['required', 'email', 'max:255'],
            'shipping_address' => ['required', 'string', 'max:1000'],
        ]);

        try {
            $result = $this->checkoutService->process($validated);
            $order  = $result['order'];

            // If we have a snap_token, pass it to the success page for Snap popup
            return redirect()->route('orders.success', $order->order_number)
                ->with('snap_token', $result['snap_token'])
                ->with('client_key', $this->gateway->getClientKey())
                ->with('snap_js_url', $this->gateway->getSnapJsUrl());

        } catch (\RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}
