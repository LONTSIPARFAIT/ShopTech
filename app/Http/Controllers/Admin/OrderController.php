<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Orders/Index', [
            'orders' => Order::with('user')->latest()->get(),
        ]);
    }

    public function show(Order $order): Response
    {
        return Inertia::render('Admin/Orders/Show', [
            'order' => $order->load(['user', 'items.product', 'items.variant']),
        ]);
    }

    public function update(Order $order)
    {
        $order->update(request()->only('status', 'payment_status'));

        return back()->with('success', 'Commande mise à jour.');
    }
}
