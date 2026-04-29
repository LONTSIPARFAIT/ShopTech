<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;

#[Fillable(['product_id', 'path', 'is_featured'])]
class ProductImage extends Model
{
    use HasFactory;

    protected $appends = ['url'];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
        ];
    }

    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => 
                str_starts_with($attributes['path'], 'http') ? $attributes['path'] : Storage::url($attributes['path']),
        );
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
