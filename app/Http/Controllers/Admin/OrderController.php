<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderStatusService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected OrderStatusService $orderStatusService;

    public function __construct(OrderStatusService $orderStatusService)
    {
        $this->orderStatusService = $orderStatusService;
    }

    /**
     * List all orders for admin.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = Order::with(['payment'])->latest();

        if ($status && in_array($status, ['pending', 'paid', 'shipped', 'delivered', 'cancelled'])) {
            $query->where('status', $status);
        }

        $orders = $query->paginate(15);

        return view('pages.orders', compact('orders', 'status'));
    }

    /**
     * Show a single order detail for admin.
     */
    public function show(Order $order)
    {
        $order->load(['items', 'payment', 'user']);

        return view('pages.admin-order-detail', compact('order'));
    }

    /**
     * Update order shipping info (mark as shipped).
     */
    public function updateShipping(Request $request, Order $order)
    {
        $validated = $request->validate([
            'shipping_courier' => ['nullable', 'string', 'max:100'],
            'shipping_service' => ['nullable', 'string', 'max:100'],
            'tracking_number'  => ['nullable', 'string', 'max:255'],
        ]);

        $this->orderStatusService->markAsShipped(
            $order,
            $validated['shipping_courier'] ?? null,
            $validated['shipping_service'] ?? null,
            $validated['tracking_number'] ?? null,
        );

        return back()->with('success', 'Pesanan ditandai sebagai dikirim.');
    }

    /**
     * Update order status (delivered / cancelled).
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:delivered,cancelled'],
        ]);

        try {
            match ($validated['status']) {
                'delivered'  => $this->orderStatusService->markAsDelivered($order),
                'cancelled'  => $this->orderStatusService->cancel($order),
            };

            return back()->with('success', 'Status pesanan berhasil diperbarui.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
