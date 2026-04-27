<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        Promotion::create([
            'name' => 'Réduction Quantité - 10%',
            'type' => 'percentage',
            'value' => 10.00,
            'min_quantity' => 3,
            'is_active' => true,
        ]);

        Promotion::create([
            'name' => 'Réduction Quantité - 20%',
            'type' => 'percentage',
            'value' => 20.00,
            'min_quantity' => 5,
            'is_active' => true,
        ]);

        Promotion::create([
            'name' => 'Remise Spéciale 50€',
            'type' => 'fixed',
            'value' => 50.00,
            'min_quantity' => 10,
            'is_active' => true,
        ]);
    }
}
