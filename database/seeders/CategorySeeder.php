<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Électronique',
                'description' => 'Derniers gadgets et appareils électroniques.',
                'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Mode',
                'description' => 'Vêtements et accessoires tendance.',
                'image' => 'https://images.unsplash.com/photo-1445205170230-053b830c6050?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Maison & Déco',
                'description' => 'Tout pour votre intérieur.',
                'image' => 'https://images.unsplash.com/photo-1484101403633-562f891dc89a?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Beauté',
                'description' => 'Soins et cosmétiques.',
                'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdc4033c8?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Sport',
                'description' => 'Équipements et vêtements de sport.',
                'image' => 'https://images.unsplash.com/photo-1461896704690-464a18dd6d58?q=80&w=800&auto=format&fit=crop',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'image' => $category['image'],
            ]);
        }
    }
}
