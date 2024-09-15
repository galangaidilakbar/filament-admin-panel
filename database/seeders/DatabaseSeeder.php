<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $superAdmin = User::factory()->create([
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
            DistrictSeeder::class,
        ]);

        // Warning: this command should be run on the last line of the seeder
        Artisan::call('shield:generate --all');
        Artisan::call('shield:super-admin --user='.$superAdmin->id);
    }
}
