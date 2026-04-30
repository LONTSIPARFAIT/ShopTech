<?php

namespace App\Actions;

use App\Models\Cart;
use App\Models\Promotion;

class ApplyPromotionAction
{
    public function execute(Cart $cart): float
    {
        $totalDiscount = 0;

        foreach ($cart->items as $item) {
            $product = $item->product;
            
            // Check if product has a valid wholesale promotion and quantity meets the threshold
            if (
                $product && 
                $product->promo_min_quantity > 0 && 
                $product->promo_discount_percent > 0 && 
                $item->quantity >= $product->promo_min_quantity
            ) {
                $basePrice = (float) $product->base_price + (float) ($item->variant->price_override ?? 0);
                $itemTotal = $basePrice * $item->quantity;
                $discountAmount = $itemTotal * ($product->promo_discount_percent / 100);
                
                $totalDiscount += $discountAmount;
            }
        }

        return $totalDiscount;
    }
}
