<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Product::with(['category', 'featuredImage', 'variants'])
            ->where('is_active', true);

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Category
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Sorting
        match ($request->sort) {
            'price_asc' => $query->orderBy('base_price', 'asc'),
            'price_desc' => $query->orderBy('base_price', 'desc'),
            'name_asc' => $query->orderBy('name', 'asc'),
            default => $query->latest(),
        };

        return Inertia::render('Products/Index', [
            'products' => $query->paginate(12)->withQueryString(),
            'categories' => Category::all(),
            'filters' => $request->only(['search', 'category', 'sort'])
        ]);
    }

    public function show(string $slug): Response
    {
        $product = Product::with(['category', 'images', 'variants'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return Inertia::render('Products/Show', [
            'product' => $product,
            'relatedProducts' => Product::with(['category', 'featuredImage'])
                ->where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->limit(4)
                ->get()
        ]);
    }
}
