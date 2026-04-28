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
        $electronics = Category::where('slug', 'electronique')->first();
        $mode = Category::where('slug', 'mode')->first();

        // Product 1: Smartphone
        $p1 = Product::create([
            'category_id' => $electronics->id,
            'name' => 'iPhone 15 Pro',
            'slug' => 'iphone-15-pro',
            'description' => 'Le dernier iPhone avec puce A17 Pro et système de caméra avancé.',
            'base_price' => 750000,
            'original_price' => 850000,
            'is_active' => true,
        ]);

        ProductImage::create(['product_id' => $p1->id, 'path' => 'https://images.unsplash.com/photo-1696446701796-da61225697cc?q=80&w=800', 'is_featured' => true]);
        ProductImage::create(['product_id' => $p1->id, 'path' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?q=80&w=800', 'is_featured' => false]);
        ProductImage::create(['product_id' => $p1->id, 'path' => 'https://images.unsplash.com/photo-1695048132803-0c4656910629?q=80&w=800', 'is_featured' => false]);

        Variant::create(['product_id' => $p1->id, 'name' => 'Couleur', 'value' => 'Titane Naturel', 'color_code' => '#BEB7A4', 'price_override' => 0, 'stock' => 50]);
        Variant::create(['product_id' => $p1->id, 'name' => 'Couleur', 'value' => 'Titane Bleu', 'color_code' => '#272D39', 'price_override' => 0, 'stock' => 30]);
        Variant::create(['product_id' => $p1->id, 'name' => 'Stockage', 'value' => '256GB', 'price_override' => 50000, 'stock' => 15]);

        // Product 2: Headphones
        $p2 = Product::create([
            'category_id' => $electronics->id,
            'name' => 'Sony WH-1000XM5',
            'slug' => 'sony-wh-1000xm5',
            'description' => 'Casque à réduction de bruit sans fil de pointe.',
            'base_price' => 225000,
            'original_price' => 250000,
            'is_active' => true,
        ]);

        ProductImage::create(['product_id' => $p2->id, 'path' => 'https://images.unsplash.com/photo-1675102008933-7221665a5885?q=80&w=800', 'is_featured' => true]);
        ProductImage::create(['product_id' => $p2->id, 'path' => 'https://images.unsplash.com/photo-1675102010188-46797a780136?q=80&w=800', 'is_featured' => false]);

        Variant::create(['product_id' => $p2->id, 'name' => 'Couleur', 'value' => 'Noir', 'color_code' => '#000000', 'price_override' => 0, 'stock' => 100]);
        Variant::create(['product_id' => $p2->id, 'name' => 'Couleur', 'value' => 'Argent', 'color_code' => '#C0C0C0', 'price_override' => 5000, 'stock' => 45]);

        // Product 3: T-Shirt
        $p3 = Product::create([
            'category_id' => $mode->id,
            'name' => 'T-Shirt Coton Bio',
            'slug' => 't-shirt-coton-bio',
            'description' => 'T-shirt confortable en coton 100% biologique.',
            'base_price' => 15000,
            'is_active' => true,
        ]);

        ProductImage::create(['product_id' => $p3->id, 'path' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=800', 'is_featured' => true]);

        Variant::create(['product_id' => $p3->id, 'name' => 'Taille', 'value' => 'M', 'price_override' => 0, 'stock' => 150]);
        Variant::create(['product_id' => $p3->id, 'name' => 'Taille', 'value' => 'L', 'price_override' => 0, 'stock' => 80]);
        Variant::create(['product_id' => $p3->id, 'name' => 'Couleur', 'value' => 'Blanc', 'color_code' => '#FFFFFF', 'price_override' => 0, 'stock' => 200]);

        // Add more products
        $products = [
            ['name' => 'MacBook Air M2', 'price' => 850000, 'cat' => $electronics, 'img' => 'https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?q=80&w=800'],
            ['name' => 'Veste en Jean', 'price' => 45000, 'cat' => $mode, 'img' => 'https://images.unsplash.com/photo-1576871337622-98d48d1cf027?q=80&w=800'],
            ['name' => 'Montre Connectée', 'price' => 150000, 'cat' => $electronics, 'img' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=800'],
            ['name' => 'Sneakers White', 'price' => 65000, 'cat' => $mode, 'img' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=800'],
        ];

        foreach ($products as $p) {
            $product = Product::create([
                'category_id' => $p['cat']->id,
                'name' => $p['name'],
                'slug' => Str::slug($p['name']),
                'description' => 'Description détaillée pour '.$p['name'],
                'base_price' => $p['price'],
                'is_active' => true,
            ]);
            ProductImage::create(['product_id' => $product->id, 'path' => $p['img'], 'is_featured' => true]);
            Variant::create(['product_id' => $product->id, 'name' => 'Standard', 'value' => 'Unique', 'price_override' => 0, 'stock' => rand(10, 100)]);
        }
    }
}
