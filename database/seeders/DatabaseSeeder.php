<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'role' => 'admin',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Coba',
            'email' => 'coba@gmail.com',
            'password' => bcrypt('123456'),
            'role' => 'sopir',
        ]);
    }
}
