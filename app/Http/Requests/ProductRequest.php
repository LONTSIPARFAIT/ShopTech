<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . ($this->product?->id ?? ''),
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
            'variants' => 'required|array|min:1',
            'variants.*.name' => 'required|string',
            'variants.*.value' => 'required|string',
            'variants.*.color_code' => 'nullable|string',
            'variants.*.price_override' => 'nullable|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
            'featured_image' => 'nullable|image|max:5120',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|max:5120',
            'remove_image_ids' => 'nullable|string',
        ];
    }
}
