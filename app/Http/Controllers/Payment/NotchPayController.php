<?php

namespace App\Http\Controllers\Payment;

use App\Actions\InitializeNotchPayPaymentAction;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NotchPayController extends Controller
{
    public function init(Order $order, InitializeNotchPayPaymentAction $initializePayment)
    {
        $url = $initializePayment->execute($order);

        if ($url) {
            return Inertia::location($url);
        }

        return back()->with('error', 'Impossible d\'initialiser le paiement.');
    }

    public function callback(Request $request, PaymentService $paymentService)
    {
        $reference = $request->query('reference');
        
        if ($paymentService->verify($reference)) {
            $order = Order::where('payment_id', $reference)->first();
            if ($order) {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'processing'
                ]);
                return redirect()->route('orders.show', $order)->with('success', 'Paiement réussi !');
            }
        }

        return redirect()->route('dashboard')->with('error', 'Le paiement a échoué.');
    }
}
