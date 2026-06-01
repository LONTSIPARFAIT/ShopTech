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
                'description' => 'Accessoires et matériel de plomberie : tuyaux, raccords, robinetterie, chauffe-eau et pièces détachées.',
                'image' => 'https://images.unsplash.com/photo-1581244277943-fe4a9c777189?q=80&w=800&auto=format&fit=crop',
                'children' => [
                    [
                        'name' => 'Robinetterie',
                        'description' => 'Robinetterie moderne pour cuisine et salle de bain, mélangeurs, mitigeurs et accessoires.',
                        'image' => 'https://images.unsplash.com/photo-1563179335-1b78f4b7b1d5?q=80&w=800&auto=format&fit=crop',
                    ],
                    [
                        'name' => 'Tuyauterie',
                        'description' => 'Tuyaux et raccords PVC, multicouche et cuivre pour installations d’eau froide et chaude.',
                        'image' => 'https://images.unsplash.com/photo-1581092335392-8bda2b5f8b3e?q=80&w=800&auto=format&fit=crop',
                    ],
                    [
                        'name' => 'Chauffage',
                        'description' => 'Solutions de chauffage : chauffe-eau, radiateurs, pompes de circulation et pièces détachées.',
                        'image' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=800&auto=format&fit=crop',
                    ],
                ],
            ],
            [
                'name' => 'Électricité',
                'description' => 'Accessoires électriques : câbles, tableaux, interrupteurs, éclairage LED et pièces détachées.',
                'image' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?q=80&w=800&auto=format&fit=crop',
                'children' => [
                    [
                        'name' => 'Tableaux Électriques',
                        'description' => 'Tableaux électriques, coffrets et accessoires pour installations domestiques et industrielles.',
                        'image' => 'https://images.unsplash.com/photo-1621905252507-b354bcadc964?q=80&w=800&auto=format&fit=crop',
                    ],
                    [
                        'name' => 'Câblage',
                        'description' => 'Câbles et nappes électriques, conducteurs isolés pour courant fort et faible.',
                        'image' => 'https://images.unsplash.com/photo-1545239351-1141bd82e8a6?q=80&w=800&auto=format&fit=crop',
                    ],
                    [
                        'name' => 'Éclairage',
                        'description' => 'Solutions d’éclairage LED, downlights, projecteurs et luminaires techniques.',
                        'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?q=80&w=800&auto=format&fit=crop',
                    ],
                ],
            ],
        ];

        foreach ($categories as $category) {
            $root = Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'image' => $category['image'],
            ]);

            foreach ($category['children'] as $child) {
                Category::create([
                    'name' => $child['name'],
                    'slug' => Str::slug($child['name']),
                    'description' => $child['description'],
                    'image' => $child['image'],
                    'parent_id' => $root->id,
                ]);
            }
        }
    }
}
