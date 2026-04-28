<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    public function initialize(Order $order): ?string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => config('notchpay.public_key'),
                'Accept' => 'application/json',
                'X-Grant' => config('notchpay.secret_key'),
            ])->post(config('notchpay.endpoint') . '/payments/initialize', [
                'amount' => (int) $order->total_amount,
                'currency' => 'XAF',
                'customer' => [
                    'email' => $order->user->email,
                    'name' => $order->user->name,
                ],
                'reference' => 'order_' . $order->id . '_' . time(),
                'callback' => route('payment.notchpay.callback'),
                'description' => 'Achat ShopTech - Commande #' . $order->id,
                'items' => $order->items->map(fn($item) => [
                    'name' => $item->product->name . ($item->variant ? ' (' . $item->variant->value . ')' : ''),
                    'amount' => (int) $item->price,
                    'quantity' => $item->quantity,
                ])->toArray(),
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $order->update(['payment_id' => $data['transaction']['reference']]);
                return $data['authorization_url'];
            }

            Log::error('Notch Pay Initialization Failed: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('Notch Pay Exception: ' . $e->getMessage());
            return null;
        }
    }

    public function verify(string $reference): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => config('notchpay.public_key'),
                'Accept' => 'application/json',
                'X-Grant' => config('notchpay.secret_key'),
            ])->get(config('notchpay.endpoint') . '/payments/' . $reference);

            if ($response->successful()) {
                $data = $response->json();
                return $data['transaction']['status'] === 'complete';
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Notch Pay Verification Exception: ' . $e->getMessage());
            return false;
        }
    }
}
