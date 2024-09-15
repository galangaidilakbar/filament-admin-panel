<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\PostalCode;
use Illuminate\Database\Seeder;

class PostalCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = District::limit(10)->get();

        $districts->each(function (District $district) {
            PostalCode::factory(10)->for($district)->create();
        });
    }
}
