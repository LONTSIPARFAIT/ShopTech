<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(): Response
    {
        $products = Product::with(['category', 'variants', 'featuredImage'])->latest()->get();

        return Inertia::render('Admin/Products/Index', [
            'products' => $products,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Products/Form', [
            'categories' => Category::with('children')->whereNull('parent_id')->get(),
            'product' => null,
        ]);
    }

    public function store(ProductRequest $request)
    {
        DB::transaction(function () use ($request) {
            $product = Product::create($request->validated());

            $validatedVariants = $request->validated()['variants'] ?? [];
            foreach ($validatedVariants as $variantData) {
                $product->variants()->create($variantData);
            }

            $this->handleImages($request, $product);
        });

        return redirect()->route('admin.products.index')->with('success', 'Produit créé avec succès.');
    }

    public function edit(Product $product): Response
    {
        return Inertia::render('Admin/Products/Form', [
            'categories' => Category::with('children')->whereNull('parent_id')->get(),
            'product' => $product->load(['variants', 'images']),
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        DB::transaction(function () use ($request, $product) {
            $product->update($request->validated());

            // Robust variants update: only delete variants that don't have orders
            $newVariantData = $request->validated()['variants'] ?? [];
            $existingVariantIds = $product->variants->pluck('id')->toArray();

            // For simplicity, we'll keep the existing delete-recreate logic
            // but wrapped in a try-catch or better: update existing ones.
            // Actually, let's just update based on name/value match or recreate if impossible.
            // But the current code is: $product->variants()->delete();
            // Let's replace it with a safer sync:
            $keptIds = [];
            foreach ($newVariantData as $vData) {
                $variant = $product->variants()->updateOrCreate(
                    ['name' => $vData['name'], 'value' => $vData['value']],
                    $vData
                );
                $keptIds[] = $variant->id;
            }

            // Delete variants that were NOT in the new data AND have no orders
            $product->variants()
                ->whereNotIn('id', $keptIds)
                ->whereDoesntHave('orderItems')
                ->delete();

            $this->handleImages($request, $product);
        });

        return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy(Product $product)
    {
        // Delete associated images from storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produit supprimé.');
    }

    /**
     * Handle image uploads: featured image + gallery images.
     */
    private function handleImages(ProductRequest $request, Product $product): void
    {
        // Featured image
        if ($request->hasFile('featured_image')) {
            // Remove old featured image
            $old = $product->images()->where('is_featured', true)->first();
            if ($old) {
                Storage::disk('public')->delete($old->path);
                $old->delete();
            }

            $path = $request->file('featured_image')->store('products', 'public');
            $product->images()->create(['path' => $path, 'is_featured' => true]);
        }

        // Gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $path = $file->store('products', 'public');
                $product->images()->create(['path' => $path, 'is_featured' => false]);
            }
        }

        // Remove images by ID if requested
        if ($request->filled('remove_image_ids')) {
            $ids = $request->input('remove_image_ids');
            if (is_string($ids)) {
                $ids = array_filter(explode(',', $ids));
            }

            $toRemove = $product->images()->whereIn('id', $ids)->get();
            foreach ($toRemove as $img) {
                Storage::disk('public')->delete($img->path);
                $img->delete();
            }
        }
    }
}
