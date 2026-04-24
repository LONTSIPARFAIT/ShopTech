<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'type', 'value', 'min_quantity', 'is_active'])]
class Promotion extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'min_quantity' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
