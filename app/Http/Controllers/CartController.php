<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Actions\ApplyPromotionAction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService) {}

    public function index(ApplyPromotionAction $applyPromotion): Response
    {
        $cart = $this->cartService->getCart()->load(['items.product.featuredImage', 'items.variant']);
        $discount = $applyPromotion->execute($cart);
        
        return Inertia::render('Cart/Index', [
            'cart' => $cart,
            'total' => max(0, $cart->total - $discount),
            'subtotal' => $cart->total,
            'discount' => $discount,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $this->cartService->addItem(
            $request->product_id,
            $request->variant_id,
            $request->quantity
        );

        return back()->with('success', 'Produit ajouté au panier.');
    }

    public function update(Request $request, int $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $this->cartService->updateQuantity($itemId, $request->quantity);

        return back()->with('success', 'Quantité mise à jour.');
    }

    public function destroy(int $itemId)
    {
        $this->cartService->removeItem($itemId);

        return back()->with('success', 'Produit retiré du panier.');
    }
}
