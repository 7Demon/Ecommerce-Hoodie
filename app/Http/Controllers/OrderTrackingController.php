<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    /**
     * Show order success page after checkout.
     */
    public function success(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items', 'payment'])
            ->firstOrFail();

        return view('pages.order-success', compact('order'));
    }

    /**
     * Show guest order tracking form.
     */
    public function showTrackForm()
    {
        return view('pages.order-track');
    }

    /**
     * Process guest order tracking.
     */
    public function track(Request $request)
    {
        $validated = $request->validate([
            'order_number'   => ['required', 'string'],
            'customer_email' => ['required', 'email'],
        ]);

        $order = Order::where('order_number', $validated['order_number'])
            ->where('customer_email', $validated['customer_email'])
            ->with(['items', 'payment'])
            ->first();

        if (!$order) {
            return back()->withInput()
                ->with('error', 'Pesanan tidak ditemukan. Periksa kembali nomor pesanan dan email Anda.');
        }

        return view('pages.order-track', compact('order'));
    }
}
