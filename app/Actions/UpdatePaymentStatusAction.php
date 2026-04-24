<?php

namespace App\Actions;

use App\Models\Order;

class UpdatePaymentStatusAction
{
    public function execute(string $reference, string $status): void
    {
        $order = Order::where('payment_id', $reference)->first();

        if ($order) {
            $paymentStatus = match ($status) {
                'complete' => 'paid',
                'failed' => 'failed',
                'cancelled' => 'cancelled',
                default => 'unpaid',
            };

            $orderStatus = match ($status) {
                'complete' => 'processing',
                'cancelled' => 'cancelled',
                default => $order->status,
            };

            $order->update([
                'payment_status' => $paymentStatus,
                'status' => $orderStatus,
            ]);
        }
    }
}
