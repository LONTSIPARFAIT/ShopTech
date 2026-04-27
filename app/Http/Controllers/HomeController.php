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
            'featuredProducts' => Product::with(['category', 'featuredImage', 'variants'])
                ->where('is_active', true)
                ->latest()
                ->take(8)
                ->get(),
            'categories' => Category::all(),
        ]);
    }
}
