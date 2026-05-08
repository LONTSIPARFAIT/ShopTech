<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Categories/Index', [
            'categories' => Category::withCount('products')->latest()->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Categories/Form', [
            'category' => null,
        ]);
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('image_file')) {
            $data['image'] = $request->file('image_file')->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie créée avec succès.');
    }

    public function edit(Category $category): Response
    {
        return Inertia::render('Admin/Categories/Form', [
            'category' => $category,
        ]);
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('image_file')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image_file')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée.');
    }
}
