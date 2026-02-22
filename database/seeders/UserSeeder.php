<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
                'theme_color' => 'primary',
                'force_password_change' => false,
            ]
        );

        for ($i = 1; $i <= 3; $i++) {
            User::firstOrCreate(
                ['email' => "admin{$i}@example.com"],
                [
                    'name' => "Admin User {$i}",
                    'password' => Hash::make('password'),
                    'role' => 'admin',
                    'theme_color' => 'primary',
                    'force_password_change' => false,
                ]
            );
        }

        for ($i = 1; $i <= 5; $i++) {
            $company = \App\Models\Company::create([
                'name' => "Company {$i}",
                'email' => "company{$i}@example.com",
                'status' => 'active',
                'registration_number' => 'REG-' . rand(1000, 9999),
                'address' => '123 Business St, Suite ' . $i,
                'phone' => '+6012345678' . $i,
            ]);

            User::firstOrCreate(
                ['email' => "manager{$i}@company{$i}.com"],
                [
                    'name' => "Company Manager {$i}",
                    'password' => Hash::make('password'),
                    'role' => 'company',
                    'theme_color' => 'primary',
                    'company_id' => $company->id,
                    'force_password_change' => true,
                ]
            );

            for ($j = 1; $j <= 5; $j++) {
                User::firstOrCreate(
                    ['email' => "driver{$j}@company{$i}.com"],
                    [
                        'name' => "Company {$i} Driver {$j}",
                        'password' => Hash::make('password'),
                        'role' => 'driver',
                        'theme_color' => 'primary',
                        'company_id' => $company->id,
                        'force_password_change' => true,
                    ]
                );
            }
        }

        for ($k = 1; $k <= 5; $k++) {
            User::firstOrCreate(
                ['email' => "freelance_driver{$k}@example.com"],
                [
                    'name' => "Freelance Driver {$k}",
                    'password' => Hash::make('password'),
                    'role' => 'driver',
                    'theme_color' => 'primary',
                    'company_id' => null,
                    'force_password_change' => true,
                ]
            );
        }
    }
}
