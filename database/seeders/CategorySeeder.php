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
                'name' => 'Plomberie',
                'description' => 'Tout pour vos installations d\'eau : tuyaux, raccords, robinetterie et chauffe-eau.',
                'image' => 'https://images.unsplash.com/photo-1581244277943-fe4a9c777189?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Électricité',
                'description' => 'Matériel électrique professionnel : câbles, tableaux, interrupteurs et éclairage.',
                'image' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Matériaux de Construction',
                'description' => 'Gros œuvre et second œuvre : ciment, briques, isolants et structures.',
                'image' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Outillage',
                'description' => 'Outils électroportatifs et manuels pour tous vos travaux.',
                'image' => 'https://images.unsplash.com/photo-1581147036324-c17ac41dfa6c?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Peinture & Revêtement',
                'description' => 'Peintures, vernis, carrelages et parquets pour vos finitions.',
                'image' => 'https://images.unsplash.com/photo-1589939705384-5185137a7f0f?q=80&w=800&auto=format&fit=crop',
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
