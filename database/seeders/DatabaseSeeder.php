<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::factory()->create([
            'name' => 'Admin ShopTech',
            'email' => 'admin@shoptech.com',
            'password' => Hash::make('password'),
            'role' => UserRole::ADMIN->value,
        ]);

        // Client User
        User::factory()->create([
            'name' => 'Client Demo',
            'email' => 'client@example.com',
            'password' => Hash::make('password'),
            'role' => UserRole::CLIENT->value,
        ]);

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            PromotionSeeder::class,
        ]);
    }
}
