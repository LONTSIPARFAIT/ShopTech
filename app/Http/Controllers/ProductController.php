<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

        $selectedCategory = null;
        $subcategories = [];

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Category filtering with support for parent categories and subcategories
        if ($request->filled('category')) {
            $selectedCategory = Category::with('children')
                ->where('slug', $request->category)
                ->first();

            if ($selectedCategory) {
                if (is_null($selectedCategory->parent_id)) {
                    $query->whereHas('category', function ($q) use ($selectedCategory) {
                        $q->where('parent_id', $selectedCategory->id)
                          ->orWhere('id', $selectedCategory->id);
                    });

                    $subcategories = $selectedCategory->children;
                } else {
                    $query->where('category_id', $selectedCategory->id);
                }
            }
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
            'categories' => Category::with('children')->whereNull('parent_id')->get(),
            'subcategories' => $subcategories,
            'filters' => $request->only(['search', 'category', 'sort']),
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
