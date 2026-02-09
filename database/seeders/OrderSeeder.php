<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have customers and vehicles
        $customers = Customer::all();
        $vehicles = Vehicle::all();

        if ($customers->isEmpty() || $vehicles->isEmpty()) {
            $this->command->info('No customers or vehicles found. Skipping OrderSeeder.');
            return;
        }

        $customer = $customers->first();
        $vehicle1 = $vehicles->first();
        $vehicle2 = $vehicles->count() > 1 ? $vehicles->get(1) : $vehicle1;

        // Scenario 1: Vehicle 1, Date X
        Order::create([
            'customer_id' => $customer->id,
            'vehicle_id' => $vehicle1->id,
            'pickup_address' => 'KLCC, Kuala Lumpur',
            'pickup_latitude' => 3.15785,
            'pickup_longitude' => 101.712,
            'dropoff_address' => 'KLIA, Sepang',
            'dropoff_latitude' => 2.74106,
            'dropoff_longitude' => 101.698,
            'distance_km' => 60.5,
            'vehicle_multiplier' => $vehicle1->price_multiplier,
            'total_price' => 150.00 * $vehicle1->price_multiplier,
            'status' => 'confirmed',
            'scheduled_at' => Carbon::now()->addDays(1)->setTime(10, 0), // Tomorrow at 10 AM
        ]);

        // Scenario 2: Vehicle 2, Date Y (Different Car, Different Date)
        if ($vehicle2->id !== $vehicle1->id) {
            Order::create([
                'customer_id' => $customers->count() > 1 ? $customers->get(1)->id : $customer->id,
                'vehicle_id' => $vehicle2->id,
                'pickup_address' => 'Pavilion KL',
                'pickup_latitude' => 3.14885,
                'pickup_longitude' => 101.713,
                'dropoff_address' => 'Batu Caves',
                'dropoff_latitude' => 3.23788,
                'dropoff_longitude' => 101.684,
                'distance_km' => 15.2,
                'vehicle_multiplier' => $vehicle2->price_multiplier,
                'total_price' => 50.00 * $vehicle2->price_multiplier,
                'status' => 'pending',
                'scheduled_at' => Carbon::now()->addDays(2)->setTime(14, 30), // Day after tomorrow at 2:30 PM
            ]);
        }

        // Scenario 3: Vehicle 1, Date Z (Same Car, Different Date)
        Order::create([
            'customer_id' => $customer->id,
            'vehicle_id' => $vehicle1->id,
            'pickup_address' => 'Mid Valley Megamall',
            'pickup_latitude' => 3.11796,
            'pickup_longitude' => 101.678,
            'dropoff_address' => 'Sunway Pyramid',
            'dropoff_latitude' => 3.07328,
            'dropoff_longitude' => 101.607,
            'distance_km' => 12.8,
            'vehicle_multiplier' => $vehicle1->price_multiplier,
            'total_price' => 45.00 * $vehicle1->price_multiplier,
            'status' => 'completed',
            'scheduled_at' => Carbon::now()->subDays(1)->setTime(9, 0), // Yesterday at 9 AM
        ]);

        // Scenario 4: Vehicle 1, Another Date (Same Car, create conflict check)
        Order::create([
            'customer_id' => $customer->id,
            'vehicle_id' => $vehicle1->id,
            'pickup_address' => 'One Utama',
            'pickup_latitude' => 3.1509,
            'pickup_longitude' => 101.6148,
            'dropoff_address' => 'Genting Highlands',
            'dropoff_latitude' => 3.4221,
            'dropoff_longitude' => 101.7946,
            'distance_km' => 55.0,
            'vehicle_multiplier' => $vehicle1->price_multiplier,
            'total_price' => 200.00 * $vehicle1->price_multiplier,
            'status' => 'confirmed',
            'scheduled_at' => Carbon::now()->addDays(5)->setTime(8, 0),
        ]);
    }
}
