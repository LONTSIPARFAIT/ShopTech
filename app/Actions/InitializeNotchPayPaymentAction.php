<?php

namespace App\Actions;

use App\Models\Order;
use App\Services\PaymentService;

class InitializeNotchPayPaymentAction
{
    public function __construct(protected PaymentService $paymentService) {}

    public function execute(Order $order): ?string
    {
        return $this->paymentService->initialize($order);
    }
}
