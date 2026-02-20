<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Resident;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin Account
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Create Resident User Account
        $residentUser = User::create([
            'name' => 'Juan Dela Cruz',
            'email' => 'resident@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'resident',
        ]);

        // 3. Create Linked Resident Profile (To prevent profile errors)
        Resident::create([
            'user_id' => $residentUser->id,
            'first_name' => 'Juan',
            'last_name' => 'Dela Cruz',
            'middle_name' => 'Protacio',
            'gender' => 'Male',
            'birthdate' => '1990-01-01',
            'is_voter' => true,
            'civil_status' => 'Single',
            'address' => 'Zone 43, Barangay 419',
        ]);
    }
}