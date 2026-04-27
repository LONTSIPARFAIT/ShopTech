<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['product_id', 'name', 'value', 'color_code', 'price_override', 'stock'])]
class Variant extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'price_override' => 'decimal:2',
            'stock' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
