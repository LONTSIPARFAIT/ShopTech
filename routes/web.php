<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Payment\NotchPayController;
use App\Http\Controllers\Payment\WebhookController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Test Role Page
    Route::inertia('test-role', 'Auth/TestRole')->name('test-role');

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
        Route::resource('orders', App\Http\Controllers\Admin\OrderController::class);
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    });

    // Client Routes
    Route::middleware(['role:client'])->prefix('client')->name('client.')->group(function () {
        Route::get('/debug', function () {
            return 'Client Access Granted';
        })->name('debug');
    });
});

// Public Catalog
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Cart
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/', [CartController::class, 'store'])->name('store');
    Route::patch('/{item}', [CartController::class, 'update'])->name('update');
    Route::delete('/{item}', [CartController::class, 'destroy'])->name('destroy');
});

// Checkout & Orders (Requires Auth)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Payment Notch Pay
    Route::get('/payment/notchpay/init/{order}', [NotchPayController::class, 'init'])->name('payment.notchpay.init');
});

// Payment Callback (Public)
Route::get('/payment/notchpay/callback', [NotchPayController::class, 'callback'])->name('payment.notchpay.callback');
Route::post('/webhooks/notchpay', [WebhookController::class, 'notchpay'])->name('webhooks.notchpay');

require __DIR__.'/settings.php';
