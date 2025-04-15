<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Route;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Route::create([
            'name' => 'Mumbai - Pune Express',
            'bus_id' => 1,
            'from' => 'Mumbai',
            'to' => 'Pune',
            'departure_time' => now()->setTime(8, 0),
            'arrival_time' => now()->setTime(11, 0),
            'fare' => 500.00,
            'status' => 'active'
        ]);

        Route::create([
            'name' => 'Mumbai - Nashik Express',
            'bus_id' => 2,
            'from' => 'Mumbai',
            'to' => 'Nashik',
            'departure_time' => now()->setTime(9, 0),
            'arrival_time' => now()->setTime(12, 30),
            'fare' => 550.00,
            'status' => 'active'
        ]);

        Route::create([
            'name' => 'Pune - Nashik Weekend',
            'bus_id' => 3,
            'from' => 'Pune',
            'to' => 'Nashik',
            'departure_time' => now()->setTime(10, 0),
            'arrival_time' => now()->setTime(14, 0),
            'fare' => 650.00,
            'status' => 'inactive'
        ]);
    }
}
