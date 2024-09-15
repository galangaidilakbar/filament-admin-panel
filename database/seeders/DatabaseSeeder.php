<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Aroma Abadi',
            'email' => 'root@email.com',
            'is_active' => true,
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'is_active' => true,
        ]);

        User::factory(10)->inactive()->create();
        User::factory(10)->active()->create();

        $this->call([
            RoleAndPermissionSeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
        ]);
    }
}
