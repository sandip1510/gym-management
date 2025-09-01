<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles if they don't exist
        $adminRole   = Role::firstOrCreate(['name' => 'admin']);
        $trainerRole = Role::firstOrCreate(['name' => 'trainer']);
        $memberRole  = Role::firstOrCreate(['name' => 'member']);

        // 👑 Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('password123')]
        );
        $admin->syncRoles([$adminRole]);

        // 🏋️ Trainer user
        $trainer = User::firstOrCreate(
            ['email' => 'trainer@example.com'],
            ['name' => 'John Trainer', 'password' => Hash::make('password123')]
        );
        $trainer->syncRoles([$trainerRole]);

        // 🙋 Member user
        $member = User::firstOrCreate(
            ['email' => 'member@example.com'],
            ['name' => 'Jane Member', 'password' => Hash::make('password123')]
        );
        $member->syncRoles([$memberRole]);

        $this->command->info('✅ Roles and sample users seeded!');
    }
}
