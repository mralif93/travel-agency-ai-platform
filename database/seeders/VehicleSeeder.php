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
                'capacity' => 14,
                'status' => 'active',
            ],
            [
                'make' => 'Toyota',
                'model' => 'Alphard',
                'year' => '2024',
                'license_plate' => 'LUX 9999',
                'capacity' => 7,
                'status' => 'active',
            ],
            [
                'make' => 'Hyundai',
                'model' => 'Starex Royale',
                'year' => '2022',
                'license_plate' => 'VIP 777',
                'capacity' => 11,
                'status' => 'maintenance',
            ],
            [
                'make' => 'Mercedes-Benz',
                'model' => 'Sprinter',
                'year' => '2023',
                'license_plate' => 'TRV 5566',
                'capacity' => 18,
                'status' => 'active',
            ],
            [
                'make' => 'Nissan',
                'model' => 'Urvan',
                'year' => '2021',
                'license_plate' => 'BGT 8888',
                'capacity' => 14,
                'status' => 'inactive',
            ],
            // Additional Fleet for New Drivers
            [
                'make' => 'Ford',
                'model' => 'Transit',
                'year' => '2023',
                'license_plate' => 'FRD 1010',
                'capacity' => 15,
                'status' => 'active',
            ],
            [
                'make' => 'Toyota',
                'model' => 'Vellfire',
                'year' => '2023',
                'license_plate' => 'VEL 2020',
                'capacity' => 7,
                'status' => 'active',
            ],
            [
                'make' => 'Maxus',
                'model' => 'V80',
                'year' => '2022',
                'license_plate' => 'MXS 3030',
                'capacity' => 12,
                'status' => 'active',
            ],
            [
                'make' => 'Toyota',
                'model' => 'Innova',
                'year' => '2024',
                'license_plate' => 'INV 4040',
                'capacity' => 7,
                'status' => 'active',
            ],
            [
                'make' => 'Hyundai',
                'model' => 'Staria',
                'year' => '2024',
                'license_plate' => 'STR 5050',
                'capacity' => 10,
                'status' => 'active',
            ],
            [
                'make' => 'Kia',
                'model' => 'Carnival',
                'year' => '2023',
                'license_plate' => 'KIA 6060',
                'capacity' => 11,
                'status' => 'active',
            ],
            [
                'make' => 'Mercedes-Benz',
                'model' => 'V-Class',
                'year' => '2022',
                'license_plate' => 'MBZ 7070',
                'capacity' => 7,
                'status' => 'active',
            ],
            [
                'make' => 'Toyota',
                'model' => 'Commuter',
                'year' => '2021',
                'license_plate' => 'CMT 8080',
                'capacity' => 14,
                'status' => 'maintenance',
            ],
            [
                'make' => 'Foton',
                'model' => 'View CS2',
                'year' => '2020',
                'license_plate' => 'FTN 9090',
                'capacity' => 13,
                'status' => 'inactive',
            ],
            [
                'make' => 'Toyota',
                'model' => 'Coaster',
                'year' => '2019',
                'license_plate' => 'CST 0000',
                'capacity' => 22,
                'status' => 'active',
            ],
        ];

        foreach ($vehicles as $index => $vehicleData) {
            // Assign a driver if available, round-robin style
            if ($drivers->isNotEmpty()) {
                $vehicleData['user_id'] = $drivers[$index % $drivers->count()]->id;
            }

            \App\Models\Vehicle::create($vehicleData);
        }
    }
}
