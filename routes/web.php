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

require __DIR__.'/settings.php';
