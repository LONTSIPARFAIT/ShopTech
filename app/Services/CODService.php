<?php

namespace App\Services;

use App\Models\Order;

class CODService
{
    public function process(Order $order): void
    {
        // For COD, we just mark the order as processing but payment remains unpaid until delivery
        // However, the instructions say "paid direct" (maybe meaning confirmed?)
        // I'll set payment_status to 'pending_on_delivery' to be clear, or 'unpaid' as per my migration
        $order->update([
            'status' => 'processing',
            'payment_status' => 'unpaid'
        ]);
    }
}
