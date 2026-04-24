<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\OrderService;
use App\Actions\ApplyPromotionAction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected OrderService $orderService,
        protected ApplyPromotionAction $applyPromotion,
        protected \App\Services\CODService $codService
    ) {}

    public function index(): Response
    {
        $cart = $this->cartService->getCart()->load(['items.product.featuredImage', 'items.variant']);
        
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $discount = $this->applyPromotion->execute($cart);

        return Inertia::render('Checkout/Index', [
            'cart' => $cart,
            'total' => max(0, $cart->total - $discount),
            'discount' => $discount,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:notchpay,cod',
            'shipping_address' => 'required|string',
            'customer_phone' => 'required|string',
        ]);

        $cart = $this->cartService->getCart();
        $order = $this->orderService->createFromCart(auth()->user(), $cart, $request->all());

        if ($request->payment_method === 'notchpay') {
            return redirect()->route('payment.notchpay.init', ['order' => $order->id]);
        }

        $this->codService->process($order);

        return redirect()->route('orders.show', ['order' => $order->id])->with('success', 'Commande validée ! Elle sera payée à la livraison.');
    }
}
