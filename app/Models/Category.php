<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'slug', 'description', 'image'])]
class Category extends Model
{
    use HasFactory;

    protected $appends = ['url'];

    protected function url(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn (mixed $value, array $attributes) => 
                isset($attributes['image']) 
                    ? (str_starts_with($attributes['image'], 'http') ? $attributes['image'] : asset('storage/' . $attributes['image']))
                    : null,
        );
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
