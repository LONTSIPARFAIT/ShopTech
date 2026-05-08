<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Variant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $plomberie = Category::where('slug', 'plomberie')->first();
        $electricite = Category::where('slug', 'electricite')->first();
        $outillage = Category::where('slug', 'outillage')->first();
        $materiaux = Category::where('slug', 'materiaux-de-construction')->first();

        // Product 1: Mitigeur Cuisine
        $p1 = Product::create([
            'category_id' => $plomberie->id,
            'name' => 'Mitigeur Cuisine Flexible',
            'slug' => 'mitigeur-cuisine-flexible',
            'description' => 'Mitigeur moderne avec douchette extractible et finition chrome haute qualité.',
            'base_price' => 45000,
            'original_price' => 55000,
            'is_active' => true,
        ]);

        ProductImage::create(['product_id' => $p1->id, 'path' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?q=80&w=800', 'is_featured' => true]);
        Variant::create(['product_id' => $p1->id, 'name' => 'Finition', 'value' => 'Chrome', 'color_code' => '#C0C0C0', 'price_override' => 0, 'stock' => 25]);
        Variant::create(['product_id' => $p1->id, 'name' => 'Finition', 'value' => 'Noir Mat', 'color_code' => '#000000', 'price_override' => 5000, 'stock' => 15]);

        // Product 2: Tableau Électrique
        $p2 = Product::create([
            'category_id' => $electricite->id,
            'name' => 'Tableau Électrique Pré-équipé',
            'slug' => 'tableau-electrique-pre-equipe',
            'description' => 'Tableau 2 rangées, 26 modules, équipé de disjoncteurs et interrupteurs différentiels.',
            'base_price' => 85000,
            'original_price' => 95000,
            'is_active' => true,
        ]);

        ProductImage::create(['product_id' => $p2->id, 'path' => 'https://images.unsplash.com/photo-1621905252507-b354bcadc964?q=80&w=800', 'is_featured' => true]);
        Variant::create(['product_id' => $p2->id, 'name' => 'Taille', 'value' => '2 Rangées', 'price_override' => 0, 'stock' => 10]);
        Variant::create(['product_id' => $p2->id, 'name' => 'Taille', 'value' => '3 Rangées', 'price_override' => 25000, 'stock' => 5]);

        // Product 3: Perceuse à percussion
        $p3 = Product::create([
            'category_id' => $outillage->id,
            'name' => 'Perceuse à Percussion 18V',
            'slug' => 'perceuse-percussion-18v',
            'description' => 'Perceuse sans fil puissante avec 2 batteries Lithium-ion et coffret de transport.',
            'base_price' => 120000,
            'is_active' => true,
        ]);

        ProductImage::create(['product_id' => $p3->id, 'path' => 'https://images.unsplash.com/photo-1504148455328-c376907d081c?q=80&w=800', 'is_featured' => true]);
        Variant::create(['product_id' => $p3->id, 'name' => 'Pack', 'value' => 'Standard (2 batteries)', 'price_override' => 0, 'stock' => 30]);

        // Add more products
        $products = [
            ['name' => 'Sac de Ciment 50kg', 'price' => 5500, 'cat' => $materiaux, 'img' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?q=80&w=800'],
            ['name' => 'Lot de 10 Interrupteurs', 'price' => 12000, 'cat' => $electricite, 'img' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?q=80&w=800'],
            ['name' => 'Projecteur LED 50W', 'price' => 18500, 'cat' => $electricite, 'img' => 'https://images.unsplash.com/photo-1550985616-10810253b84d?q=80&w=800'],
            ['name' => 'Jeu de 12 Tournevis', 'price' => 15000, 'cat' => $outillage, 'img' => 'https://images.unsplash.com/photo-1586864387917-f579ae9248de?q=80&w=800'],
        ];

        foreach ($products as $p) {
            $product = Product::create([
                'category_id' => $p['cat']->id,
                'name' => $p['name'],
                'slug' => Str::slug($p['name']),
                'description' => 'Produit de qualité professionnelle pour vos chantiers : '.$p['name'],
                'base_price' => $p['price'],
                'is_active' => true,
            ]);
            ProductImage::create(['product_id' => $product->id, 'path' => $p['img'], 'is_featured' => true]);
            Variant::create(['product_id' => $product->id, 'name' => 'Standard', 'value' => 'Unique', 'price_override' => 0, 'stock' => rand(50, 500)]);
        }
    }
}
