<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
            ]
        );
        $admin->assignRole('admin');

        // Trainer User
        $trainer = User::firstOrCreate(
            ['email' => 'trainer@example.com'],
            [
                'name' => 'Gym Trainer',
                'password' => Hash::make('password123'),
            ]
        );
        $trainer->assignRole('trainer');

        // Member User
        $member = User::firstOrCreate(
            ['email' => 'member@example.com'],
            [
                'name' => 'Regular Member',
                'password' => Hash::make('password123'),
            ]
        );
        $member->assignRole('member');
    }
}
