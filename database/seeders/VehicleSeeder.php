<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drivers = \App\Models\User::where('role', 'driver')->get();

        $vehicles = [
            // Original Fleet
            [
                'make' => 'Toyota',
                'model' => 'Hiace Commuter',
                'year' => '2023',
                'license_plate' => 'ABC 1234',
                'capacity' => 13, // Drivers excluded
                'type' => 'van',
                'status' => 'active',
                'price_multiplier' => 1.2,
            ],
            [
                'make' => 'Toyota',
                'model' => 'Alphard',
                'year' => '2024',
                'license_plate' => 'LUX 9999',
                'capacity' => 6,
                'type' => 'mpv',
                'status' => 'active',
                'price_multiplier' => 2.5,
            ],
            [
                'make' => 'Hyundai',
                'model' => 'Starex Royale',
                'year' => '2022',
                'license_plate' => 'VIP 777',
                'capacity' => 10,
                'type' => 'mpv',
                'status' => 'maintenance',
                'price_multiplier' => 1.5,
            ],
            [
                'make' => 'Mercedes-Benz',
                'model' => 'Sprinter',
                'year' => '2023',
                'license_plate' => 'TRV 5566',
                'capacity' => 17,
                'type' => 'van',
                'status' => 'active',
                'price_multiplier' => 2.0,
            ],
            [
                'make' => 'Nissan',
                'model' => 'Urvan',
                'year' => '2021',
                'license_plate' => 'BGT 8888',
                'capacity' => 13,
                'type' => 'van',
                'status' => 'inactive',
                'price_multiplier' => 1.1,
            ],
            // Additional Fleet for New Drivers
            [
                'make' => 'Ford',
                'model' => 'Transit',
                'year' => '2023',
                'license_plate' => 'FRD 1010',
                'capacity' => 14,
                'type' => 'van',
                'status' => 'active',
                'price_multiplier' => 1.3,
            ],
            [
                'make' => 'Toyota',
                'model' => 'Vellfire',
                'year' => '2023',
                'license_plate' => 'VEL 2020',
                'capacity' => 6,
                'type' => 'mpv',
                'status' => 'active',
                'price_multiplier' => 2.4,
            ],
            [
                'make' => 'Maxus',
                'model' => 'V80',
                'year' => '2022',
                'license_plate' => 'MXS 3030',
                'capacity' => 11,
                'type' => 'van',
                'status' => 'active',
                'price_multiplier' => 1.1,
            ],
            [
                'make' => 'Toyota',
                'model' => 'Innova',
                'year' => '2024',
                'license_plate' => 'INV 4040',
                'capacity' => 6,
                'type' => 'mpv',
                'status' => 'active',
                'price_multiplier' => 1.0,
            ],
            [
                'make' => 'Hyundai',
                'model' => 'Staria',
                'year' => '2024',
                'license_plate' => 'STR 5050',
                'capacity' => 9,
                'type' => 'mpv',
                'status' => 'active',
                'price_multiplier' => 1.8,
            ],
            [
                'make' => 'Kia',
                'model' => 'Carnival',
                'year' => '2023',
                'license_plate' => 'KIA 6060',
                'capacity' => 10,
                'type' => 'mpv',
                'status' => 'active',
                'price_multiplier' => 1.6,
            ],
            [
                'make' => 'Mercedes-Benz',
                'model' => 'V-Class',
                'year' => '2022',
                'license_plate' => 'MBZ 7070',
                'capacity' => 6,
                'type' => 'mpv',
                'status' => 'active',
                'price_multiplier' => 2.8,
            ],
            [
                'make' => 'Toyota',
                'model' => 'Commuter',
                'year' => '2021',
                'license_plate' => 'CMT 8080',
                'capacity' => 13,
                'type' => 'van',
                'status' => 'maintenance',
                'price_multiplier' => 1.1,
            ],
            [
                'make' => 'Foton',
                'model' => 'View CS2',
                'year' => '2020',
                'license_plate' => 'FTN 9090',
                'capacity' => 12,
                'type' => 'van',
                'status' => 'inactive',
                'price_multiplier' => 1.0,
            ],
            [
                'make' => 'Toyota',
                'model' => 'Coaster',
                'year' => '2019',
                'license_plate' => 'CST 0000',
                'capacity' => 21,
                'type' => 'bus',
                'status' => 'active',
                'price_multiplier' => 3.0,
            ],
        ];

        foreach ($vehicles as $index => $vehicleData) {
            // Assign a driver if available, round-robin style
            if ($drivers->isNotEmpty()) {
                $vehicleData['user_id'] = $drivers[$index % $drivers->count()]->id;
            }

            \App\Models\Vehicle::updateOrCreate(
                ['license_plate' => $vehicleData['license_plate']],
                $vehicleData
            );
        }
    }
}
