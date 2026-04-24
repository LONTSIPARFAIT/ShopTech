<?php

namespace App\Actions;

use App\Models\Cart;
use App\Models\Promotion;

class ApplyPromotionAction
{
    public function execute(Cart $cart): float
    {
        $totalQuantity = $cart->items->sum('quantity');
        $subtotal = $cart->total;
        
        $promotion = Promotion::where('is_active', true)
            ->where('min_quantity', '<=', $totalQuantity)
            ->orderBy('min_quantity', 'desc')
            ->first();

        if (!$promotion) {
            return 0;
        }

        if ($promotion->type === 'percentage') {
            return $subtotal * ($promotion->value / 100);
        }

        return $promotion->value;
    }
}
