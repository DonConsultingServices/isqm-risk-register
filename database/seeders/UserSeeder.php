<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@isqm.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'manager@isqm.com'],
            [
                'name' => 'Manager',
                'password' => Hash::make('manager123'),
                'role' => 'manager',
            ]
        );

        User::firstOrCreate(
            ['email' => 'staff@isqm.com'],
            [
                'name' => 'Staff Member',
                'password' => Hash::make('staff123'),
                'role' => 'staff',
            ]
        );
    }
}

