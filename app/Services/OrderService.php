<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Actions\ApplyPromotionAction;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(protected ApplyPromotionAction $applyPromotion) {}

    public function createFromCart(User $user, Cart $cart, array $data): Order
    {
        return DB::transaction(function () use ($user, $cart, $data) {
            $discount = $this->applyPromotion->execute($cart);
            $total = max(0, $cart->total - $discount);

            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
                'status' => 'pending',
                'payment_method' => $data['payment_method'] ?? 'notchpay',
                'payment_status' => 'unpaid',
                'shipping_address' => $data['shipping_address'] ?? null,
                'customer_phone' => $data['customer_phone'] ?? null,
            ]);

            foreach ($cart->items as $item) {
                $price = $item->variant && $item->variant->price_override 
                    ? (float) $item->variant->price_override 
                    : (float) $item->product->base_price;

                $order->items()->create([
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'quantity' => $item->quantity,
                    'price' => $price,
                ]);
            }

            // Clear the cart after order creation
            $cart->items()->delete();
            $cart->update(['status' => 'converted']);

            return $order;
        });
    }
}
