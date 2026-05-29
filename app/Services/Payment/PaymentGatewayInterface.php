<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Payment;

interface PaymentGatewayInterface
{
    /**
     * Create a payment transaction with the gateway.
     *
     * @return array{snap_token?: string, payment_url?: string, redirect_url?: string}
     */
    public function createTransaction(Order $order, Payment $payment): array;

    /**
     * Verify and process a webhook notification payload from the gateway.
     *
     * @return array{status: string, order_id: int, transaction_id: string}
     */
    public function handleWebhook(array $payload): array;
}
