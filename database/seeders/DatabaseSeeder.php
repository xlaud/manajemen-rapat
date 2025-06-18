<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

         // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), 
            'role' => 'admin',
        ]);

        // Guru User
        User::create([
            'name' => 'Guru User',
            'email' => 'guru@example.com',
            'password' => bcrypt('password'),
            'role' => 'guru',
        ]);

        User::create([
            'name' => 'Allaam',
            'email' => 'l200210213@student.ums.ac.id',
            'password' => bcrypt('300103'),
            'role' => 'guru',
        ]);
    }
}
