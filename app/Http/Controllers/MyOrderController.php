<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class MyOrderController extends Controller
{
    /**
     * Show authenticated user's order history.
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('payment')
            ->latest()
            ->paginate(10);

        return view('pages.my-orders', compact('orders'));
    }

    /**
     * Show single order detail for authenticated user.
     */
    public function show(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->with(['items', 'payment'])
            ->firstOrFail();

        return view('pages.order-track', compact('order'));
    }
}
