<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    // Test Role Page
    Route::inertia('test-role', 'Auth/TestRole')->name('test-role');

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/debug', function () {
            return 'Admin Access Granted';
        })->name('debug');

        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    });

    // Client Routes
    Route::middleware(['role:client'])->prefix('client')->name('client.')->group(function () {
        Route::get('/debug', function () {
            return 'Client Access Granted';
        })->name('debug');
    });
});

// Public Catalog
Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

// Cart
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [\App\Http\Controllers\CartController::class, 'index'])->name('index');
    Route::post('/', [\App\Http\Controllers\CartController::class, 'store'])->name('store');
    Route::patch('/{item}', [\App\Http\Controllers\CartController::class, 'update'])->name('update');
    Route::delete('/{item}', [\App\Http\Controllers\CartController::class, 'destroy'])->name('destroy');
});

// Checkout & Orders (Requires Auth)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');

    // Payment Notch Pay
    Route::get('/payment/notchpay/init/{order}', [\App\Http\Controllers\Payment\NotchPayController::class, 'init'])->name('payment.notchpay.init');
});

// Payment Callback (Public)
Route::get('/payment/notchpay/callback', [\App\Http\Controllers\Payment\NotchPayController::class, 'callback'])->name('payment.notchpay.callback');
Route::post('/webhooks/notchpay', [\App\Http\Controllers\Payment\WebhookController::class, 'notchpay'])->name('webhooks.notchpay');

require __DIR__.'/settings.php';
