<?php

namespace App\Http\Controllers\Payment;

use App\Actions\UpdatePaymentStatusAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function notchpay(Request $request, UpdatePaymentStatusAction $updatePaymentStatus)
    {
        // Note: In production, verify the webhook signature using config('notchpay.webhook_secret')
        
        $event = $request->input('event');
        $data = $request->input('data');

        Log::info('Notch Pay Webhook Received: ' . $event, ['data' => $data]);

        if ($event === 'payment.complete') {
            $updatePaymentStatus->execute($data['reference'], 'complete');
        } elseif ($event === 'payment.failed') {
            $updatePaymentStatus->execute($data['reference'], 'failed');
        }

        return response()->json(['status' => 'ok']);
    }
}
