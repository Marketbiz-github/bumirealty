<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role superadmin
        $role = Role::firstOrCreate(
            ['name' => 'superadmin', 'guard_name' => 'web'],
            ['id' => (string) Str::uuid()]
        );

        // Buat user superadmin
        $user = User::firstOrCreate(
            ['email' => 'admin@bumirealty.id'],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Admin',
                'password' => Hash::make('#bumirealty123'),
            ]
        );

        // Assign role superadmin ke user
        if (!$user->hasRole('superadmin')) {
            $user->assignRole('superadmin');
        }
    }
}
