<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransGateway implements PaymentGatewayInterface
{
    private string $serverKey;
    private string $clientKey;
    private string $baseUrl;
    private bool   $isProduction;

    public function __construct()
    {
        $this->isProduction = config('services.midtrans.is_production', false);
        $this->serverKey    = config('services.midtrans.server_key', '');
        $this->clientKey    = config('services.midtrans.client_key', '');
        $this->baseUrl      = $this->isProduction
            ? 'https://app.midtrans.com/snap/v1'
            : 'https://app.sandbox.midtrans.com/snap/v1';
    }

    /**
     * Create a Snap transaction via Midtrans API.
     */
    public function createTransaction(Order $order, Payment $payment): array
    {
        $items = [];
        foreach ($order->items as $item) {
            $items[] = [
                'id'       => (string) $item->product_id,
                'price'    => (int) $item->price,
                'quantity' => $item->quantity,
                'name'     => mb_substr($item->product_name, 0, 50),
            ];
        }

        // Add shipping as a line item if > 0
        if ($order->shipping_cost > 0) {
            $items[] = [
                'id'       => 'SHIPPING',
                'price'    => (int) $order->shipping_cost,
                'quantity' => 1,
                'name'     => 'Shipping Cost',
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_number,
                'gross_amount' => (int) $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $order->customer_name,
                'email'      => $order->customer_email,
            ],
            'item_details' => $items,
            'callbacks' => [
                'finish' => route('orders.success', $order->order_number),
            ],
        ];

        $response = Http::withBasicAuth($this->serverKey, '')
            ->post("{$this->baseUrl}/transactions", $params);

        if ($response->failed()) {
            Log::error('Midtrans createTransaction failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            throw new \RuntimeException('Failed to create Midtrans transaction.');
        }

        $data = $response->json();

        return [
            'snap_token'   => $data['token'] ?? null,
            'payment_url'  => $data['redirect_url'] ?? null,
            'redirect_url' => $data['redirect_url'] ?? null,
        ];
    }

    /**
     * Verify and parse a Midtrans webhook notification.
     */
    public function handleWebhook(array $payload): array
    {
        // Verify signature
        $orderId        = $payload['order_id'] ?? '';
        $statusCode     = $payload['status_code'] ?? '';
        $grossAmount    = $payload['gross_amount'] ?? '';
        $signatureKey   = $payload['signature_key'] ?? '';

        $expectedSig = hash('sha512', $orderId . $statusCode . $grossAmount . $this->serverKey);

        if ($signatureKey !== $expectedSig) {
            Log::warning('Midtrans webhook signature mismatch', compact('orderId'));
            throw new \RuntimeException('Invalid webhook signature.');
        }

        $transactionStatus = $payload['transaction_status'] ?? '';
        $fraudStatus       = $payload['fraud_status'] ?? 'accept';

        // Map Midtrans status → our internal status
        $status = match (true) {
            in_array($transactionStatus, ['capture', 'settlement'])
                && $fraudStatus === 'accept'                        => 'completed',
            $transactionStatus === 'pending'                        => 'pending',
            $transactionStatus === 'expire'                         => 'expired',
            in_array($transactionStatus, ['deny', 'cancel'])        => 'cancelled',
            default                                                 => 'failed',
        };

        return [
            'status'         => $status,
            'order_id'       => $orderId,
            'transaction_id' => $payload['transaction_id'] ?? '',
            'payment_type'   => $payload['payment_type'] ?? '',
        ];
    }

    /**
     * Get the Midtrans Client Key for frontend Snap.js.
     */
    public function getClientKey(): string
    {
        return $this->clientKey;
    }

    /**
     * Get the Snap.js script URL.
     */
    public function getSnapJsUrl(): string
    {
        return $this->isProduction
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    }
}
