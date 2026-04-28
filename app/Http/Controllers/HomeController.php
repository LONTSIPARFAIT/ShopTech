<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Inertia\Inertia;
use Laravel\Fortify\Features;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Welcome', [
            'canRegister' => Features::enabled(Features::registration()),
            'newArrivals' => Product::with(['category', 'featuredImage', 'variants'])
                ->where('is_active', true)
                ->latest()
                ->take(5)
                ->get(),
            'discountedProducts' => Product::with(['category', 'featuredImage', 'variants'])
                ->where('is_active', true)
                ->whereNotNull('original_price')
                ->latest()
                ->take(5)
                ->get(),
            'categories' => Category::withCount('products')->get(),
        ]);
    }
}
