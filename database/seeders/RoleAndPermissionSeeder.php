<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[
            \Spatie\Permission\PermissionRegistrar::class
        ]->forgetCachedPermissions();

        $roles = collect(RoleName::toArray())->map(function ($name) {
            return ['name' => $name, 'guard_name' => 'web'];
        });

        Role::insert($roles->toArray());
    }
}
