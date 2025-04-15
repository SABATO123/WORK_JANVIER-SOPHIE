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
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@buscab.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        User::factory()->create([
            'name' => 'Test Passenger',
            'email' => 'passenger@buscab.com',
            'password' => bcrypt('password'),
            'role' => 'passenger'
        ]);

        $this->call([
            BusSeeder::class,
            RouteSeeder::class
        ]);
    }
}
