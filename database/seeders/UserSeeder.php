<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin
        User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
                'theme_color' => 'primary',
            ]
        );

        // Admin
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'theme_color' => 'primary',
            ]
        );

        // Driver
        User::firstOrCreate(
            ['email' => 'driver@example.com'],
            [
                'name' => 'Driver User',
                'password' => Hash::make('password'),
                'role' => 'driver',
                'theme_color' => 'primary',
            ]
        );

        // Create 10 more drivers
        for ($i = 1; $i <= 10; $i++) {
            User::firstOrCreate(
                ['email' => "driver{$i}@example.com"],
                [
                    'name' => "Driver {$i}",
                    'password' => Hash::make('password'),
                    'role' => 'driver',
                    'theme_color' => 'primary',
                ]
            );
        }

        // Company
        User::firstOrCreate(
            ['email' => 'company@example.com'],
            [
                'name' => 'Company User',
                'password' => Hash::make('password'),
                'role' => 'company',
                'theme_color' => 'primary',
            ]
        );

        // Generate 50 random users
        User::factory(50)->create();
    }
}
