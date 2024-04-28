<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = User::create([
            'firstName' => 'Super',
            'lastName' => 'Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
        ]);

        $superadminRole = Role::where('name', 'superadmin')->first();
        $superadmin->assignRole($superadminRole);

        $admin = User::create([
            'firstName' => 'Admin',
            'lastName' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $adminRole = Role::where('name', 'admin')->first();
        $admin->assignRole($adminRole);

        $admin = User::create([
            'firstName' => 'Client',
            'lastName' => 'Client',
            'email' => 'client@example.com',
            'password' => Hash::make('password'),
        ]);

        $adminRole = Role::where('name', 'client')->first();
        $admin->assignRole($adminRole);
    }
}
