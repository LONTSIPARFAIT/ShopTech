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
        $robinetterie = Category::where('slug', 'robinetterie')->first();
        $tuyauterie = Category::where('slug', 'tuyauterie')->first();
        $chauffage = Category::where('slug', 'chauffage')->first();

        $tableaux = Category::where('slug', 'tableaux-electriques')->first();
        $cablage = Category::where('slug', 'cablage')->first();
        $eclairage = Category::where('slug', 'eclairage')->first();

        // Product 1: Mitigeur Cuisine
        $p1 = Product::create([
            'category_id' => $robinetterie->id,
            'name' => 'Mitigeur Cuisine Flexible',
            'slug' => 'mitigeur-cuisine-flexible',
            'description' => 'Mitigeur moderne avec douchette extractible et finition chrome haute qualité. Idéal pour cuisine contemporaine.',
            'base_price' => 45000,
            'original_price' => 55000,
            'is_active' => true,
        ]);

        ProductImage::create(['product_id' => $p1->id, 'path' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?q=80&w=800', 'is_featured' => true]);
        Variant::create(['product_id' => $p1->id, 'name' => 'Finition', 'value' => 'Chrome', 'color_code' => '#C0C0C0', 'price_override' => 0, 'stock' => 25]);
        Variant::create(['product_id' => $p1->id, 'name' => 'Finition', 'value' => 'Noir Mat', 'color_code' => '#000000', 'price_override' => 5000, 'stock' => 15]);

        // Product 2: Tableau Électrique
        $p2 = Product::create([
            'category_id' => $tableaux->id,
            'name' => 'Tableau Électrique Pré-équipé',
            'slug' => 'tableau-electrique-pre-equipe',
            'description' => 'Tableau 2 rangées, 26 modules, équipé de disjoncteurs et interrupteurs différentiels pour installation résidentielle.',
            'base_price' => 85000,
            'original_price' => 95000,
            'is_active' => true,
        ]);

        ProductImage::create(['product_id' => $p2->id, 'path' => 'https://images.unsplash.com/photo-1621905252507-b354bcadc964?q=80&w=800', 'is_featured' => true]);
        Variant::create(['product_id' => $p2->id, 'name' => 'Taille', 'value' => '2 Rangées', 'price_override' => 0, 'stock' => 10]);
        Variant::create(['product_id' => $p2->id, 'name' => 'Taille', 'value' => '3 Rangées', 'price_override' => 25000, 'stock' => 5]);

        $products = [
            ['name' => 'Robinet Salle de Bain Lavabo', 'price' => 28000, 'cat' => $robinetterie, 'img' => 'https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?q=80&w=800', 'desc' => 'Robinet simple pour lavabo, design contemporain et durable.'],
            ['name' => 'Tuyau PVC Ø20mm (50m)', 'price' => 12500, 'cat' => $tuyauterie, 'img' => 'https://images.unsplash.com/photo-1581092335392-8bda2b5f8b3e?q=80&w=800', 'desc' => 'Tuyau de plomberie PVC de haute qualité pour installations d\'eau.'],
            ['name' => 'Coude 90° Ø20mm (Lot de 10)', 'price' => 8000, 'cat' => $tuyauterie, 'img' => 'https://images.unsplash.com/photo-1581092335392-8bda2b5f8b3e?q=80&w=800', 'desc' => 'Raccords coudés pour tuyauterie, facilite les changements de direction.'],
            ['name' => 'Chauffe-eau Électrique 200L', 'price' => 220000, 'cat' => $chauffage, 'img' => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?q=80&w=800', 'desc' => 'Chauffe-eau électrique haute performance pour habitation.'],
            ['name' => 'Lot de 10 Interrupteurs', 'price' => 12000, 'cat' => $cablage, 'img' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?q=80&w=800', 'desc' => 'Interrupteurs muraux de qualité professionnelle, finition blanche.'],
            ['name' => 'Projecteur LED 50W', 'price' => 18500, 'cat' => $eclairage, 'img' => 'https://images.unsplash.com/photo-1550985616-10810253b84d?q=80&w=800', 'desc' => 'Projecteur LED économe en énergie pour éclairage extérieur.'],
            ['name' => 'Câble Électrique 2.5mm² (100m)', 'price' => 35000, 'cat' => $cablage, 'img' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?q=80&w=800', 'desc' => 'Câble électrique aux normes de sécurité, conforme NFC 15-100.'],
            ['name' => 'Disjoncteur 16A Monophasé', 'price' => 6500, 'cat' => $tableaux, 'img' => 'https://images.unsplash.com/photo-1621905252507-b354bcadc964?q=80&w=800', 'desc' => 'Disjoncteur de protection pour circuit électrique standard.'],
        ];

        foreach ($products as $p) {
            $product = Product::create([
                'category_id' => $p['cat']->id,
                'name' => $p['name'],
                'slug' => Str::slug($p['name']),
                'description' => $p['desc'],
                'base_price' => $p['price'],
                'is_active' => true,
            ]);
            ProductImage::create(['product_id' => $product->id, 'path' => $p['img'], 'is_featured' => true]);
            Variant::create(['product_id' => $product->id, 'name' => 'Standard', 'value' => 'Unique', 'price_override' => 0, 'stock' => rand(50, 500)]);
        }
    }
}
