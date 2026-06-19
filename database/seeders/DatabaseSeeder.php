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
        // 1. Create Admin Account (Updated with Split Name Structure)
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'middle_name' => null,
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 1, 
            'is_admin' => true,
        ]);

        // 2. Create Resident User Account (Updated with Split Name Structure)
        $residentUser = User::create([
            'first_name' => 'Juan',
            'last_name' => 'Dela Cruz',
            'middle_name' => 'Protacio',
            'email' => 'resident@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 0, 
            'is_admin' => false,
        ]);

        // 3. Create Linked Resident Profile
        Resident::create([
            'user_id' => $residentUser->id, 
            'first_name' => 'Juan',
            'last_name' => 'Dela Cruz',
            'middle_name' => 'Protacio',
            'gender' => 'Male',
            'birth_date' => '1990-01-01',
            'email' => 'juan@gmail.com',
            'is_voter' => 1,
            'civil_status' => 'Single',
            'address' => 'Zone 43, Barangay 419',
            'age' => 36,
        ]);

        // 4. Trigger the Role User Seeder (Admin, Captain, and Official accounts)
        $this->call(RoleUserSeeder::class);
    }
}