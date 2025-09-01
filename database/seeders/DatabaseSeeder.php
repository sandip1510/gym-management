<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call your seeders here
        $this->call([
            RoleSeeder::class, // if you created RoleSeeder
              AdminSeeder::class,
               UserSeeder::class, 
            // Add more seeders here if needed
        ]);
    }
}
