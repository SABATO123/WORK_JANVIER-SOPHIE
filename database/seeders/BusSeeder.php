<?php

namespace Database\Seeders;

use App\Models\Bus;
use Illuminate\Database\Seeder;

class BusSeeder extends Seeder
{
    public function run(): void
    {
        $buses = [
            [
                'name' => 'CITY Express',
                'bus_number' => 'CE001',
                'type' => 'AC',
                'total_seats' => 36,
                'features' => 'WiFi, USB Charging, Reclining Seats',
                'status' => 'active',
            ],
            [
                'name' => 'Night Rider',
                'bus_number' => 'NR002',
                'type' => 'Sleeper',
                'total_seats' => 24,
                'features' => 'Full Sleeper Beds, Reading Lights, Blankets',
                'status' => 'active',
            ],
            [
                'name' => 'Economy Plus',
                'bus_number' => 'EP003',
                'type' => 'Non-AC',
                'total_seats' => 44,
                'features' => 'Comfortable Seating, Large Windows',
                'status' => 'active',
            ],
            [
                'name' => 'Business Class',
                'bus_number' => 'BC004',
                'type' => 'AC',
                'total_seats' => 32,
                'features' => 'Extra Legroom, Entertainment System, Snacks Service',
                'status' => 'active',
            ],
        ];

        foreach ($buses as $bus) {
            Bus::create($bus);
        }
    }
}
