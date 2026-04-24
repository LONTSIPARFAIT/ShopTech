<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(): Response
    {
        $products = Product::with(['category', 'variants'])->latest()->get();
        return Inertia::render('Admin/Products/Index', [
            'products' => $products
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Products/Form', [
            'categories' => Category::all(),
            'product' => null,
        ]);
    }

    public function store(ProductRequest $request)
    {
        DB::transaction(function () use ($request) {
            $product = Product::create($request->validated());

            foreach ($request->variants as $variantData) {
                $product->variants()->create($variantData);
            }
        });

        return redirect()->route('admin.products.index')->with('success', 'Produit créé avec succès.');
    }

    public function edit(Product $product): Response
    {
        return Inertia::render('Admin/Products/Form', [
            'categories' => Category::all(),
            'product' => $product->load('variants'),
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        DB::transaction(function () use ($request, $product) {
            $product->update($request->validated());

            $product->variants()->delete();
            foreach ($request->variants as $variantData) {
                $product->variants()->create($variantData);
            }
        });

        return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produit supprimé.');
    }
}
