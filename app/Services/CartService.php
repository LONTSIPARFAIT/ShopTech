<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCart(): Cart
    {
        if (auth()->check()) {
            return Cart::firstOrCreate(
                ['user_id' => auth()->id(), 'status' => 'active'],
                ['session_id' => Session::getId()]
            );
        }

        return Cart::firstOrCreate(
            ['session_id' => Session::getId(), 'status' => 'active']
        );
    }

    public function addItem(int $productId, ?int $variantId = null, int $quantity = 1): void
    {
        $cart = $this->getCart();

        $item = $cart->items()
            ->where('product_id', $productId)
            ->where('variant_id', $variantId)
            ->first();

        if ($item) {
            $item->increment('quantity', $quantity);
        } else {
            $cart->items()->create([
                'product_id' => $productId,
                'variant_id' => $variantId,
                'quantity' => $quantity,
            ]);
        }
    }

    public function removeItem(int $itemId): void
    {
        $cart = $this->getCart();
        $cart->items()->where('id', $itemId)->delete();
    }

    public function updateQuantity(int $itemId, int $quantity): void
    {
        $cart = $this->getCart();
        $item = $cart->items()->where('id', $itemId)->first();
        if ($item) {
            $item->update(['quantity' => $quantity]);
        }
    }

    public function clear(): void
    {
        $cart = $this->getCart();
        $cart->items()->delete();
    }
}
