<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderStatusService;
use App\Services\Payment\MidtransGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    protected MidtransGateway $gateway;
    protected OrderStatusService $orderStatusService;

    public function __construct(MidtransGateway $gateway, OrderStatusService $orderStatusService)
    {
        $this->gateway            = $gateway;
        $this->orderStatusService = $orderStatusService;
    }

    /**
     * Handle Midtrans webhook notification.
     */
    public function handle(Request $request)
    {
        $payload = $request->all();

        Log::info('Midtrans webhook received', ['order_id' => $payload['order_id'] ?? 'unknown']);

        try {
            $result = $this->gateway->handleWebhook($payload);
        } catch (\RuntimeException $e) {
            Log::error('Midtrans webhook verification failed', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $order = Order::where('order_number', $result['order_id'])->first();

        if (!$order) {
            Log::warning('Midtrans webhook: order not found', $result);
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Update payment record with raw payload
        $order->payment?->update([
            'gateway_reference' => $result['transaction_id'],
            'payment_method'    => $result['payment_type'],
            'payload'           => $payload,
        ]);

        // Transition order status
        match ($result['status']) {
            'completed' => $this->orderStatusService->markAsPaid($order),
            'expired'   => $this->orderStatusService->handlePaymentFailed($order, 'expired'),
            'cancelled' => $this->orderStatusService->handlePaymentFailed($order, 'cancelled'),
            'failed'    => $this->orderStatusService->handlePaymentFailed($order, 'failed'),
            default     => null, // pending — do nothing
        };

        return response()->json(['message' => 'OK']);
    }
}
