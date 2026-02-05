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
        // 1. Super Admin
        User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
                'theme_color' => 'primary',
            ]
        );

        // 2. Admins (3)
        for ($i = 1; $i <= 3; $i++) {
            User::firstOrCreate(
                ['email' => "admin{$i}@example.com"],
                [
                    'name' => "Admin User {$i}",
                    'password' => Hash::make('password'),
                    'role' => 'admin',
                    'theme_color' => 'primary',
                ]
            );
        }

        // 3. Companies (5)
        for ($i = 1; $i <= 5; $i++) {
            $company = \App\Models\Company::create([
                'name' => "Company {$i}",
                'email' => "company{$i}@example.com",
                'status' => 'active',
                'registration_number' => 'REG-' . rand(1000, 9999),
                'address' => '123 Business St, Suite ' . $i,
                'phone' => '+6012345678' . $i,
            ]);

            // 3a. Company User (1 per company)
            User::create([
                'name' => "Company Manager {$i}",
                'email' => "manager{$i}@company{$i}.com",
                'password' => Hash::make('password'),
                'role' => 'company',
                'theme_color' => 'primary',
                'company_id' => $company->id,
            ]);

            // 3b. Drivers for this Company (5 per company)
            for ($j = 1; $j <= 5; $j++) {
                User::create([
                    'name' => "Company {$i} Driver {$j}",
                    'email' => "driver{$j}@company{$i}.com",
                    'password' => Hash::make('password'),
                    'role' => 'driver',
                    'theme_color' => 'primary',
                    'company_id' => $company->id,
                ]);
            }
        }

        // 4. Freelance Drivers (5) - No Company
        for ($k = 1; $k <= 5; $k++) {
            User::create([
                'name' => "Freelance Driver {$k}",
                'email' => "freelance_driver{$k}@example.com",
                'password' => Hash::make('password'),
                'role' => 'driver',
                'theme_color' => 'primary',
                'company_id' => null,
            ]);
        }
    }
}
