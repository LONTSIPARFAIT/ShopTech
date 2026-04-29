<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response|RedirectResponse
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return Inertia::render('Dashboard', [
            'recentOrders' => Order::where('user_id', $user->id)
                ->with('items.product')
                ->latest()
                ->limit(5)
                ->get(),
            'stats' => [
                'totalOrders' => Order::where('user_id', $user->id)->count(),
                'totalSpent' => Order::where('user_id', $user->id)->where('payment_status', 'paid')->sum('total_amount'),
            ],
        ]);
    }
}
