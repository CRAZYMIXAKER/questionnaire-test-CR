<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['user', 'admin', 'super-admin'];

        foreach ($roles as $role) {
            if (Role::where('name', $role)->doesntExist()) {
                Role::create([
                    'name' => $role,
                ]);
            }
        }
    }
}
