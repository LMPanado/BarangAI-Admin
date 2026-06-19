<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'System',
                'last_name' => 'Admin',
                'middle_name' => null,
                'email' => 'admin@brgy419.com',
                'password' => bcrypt('password'),
                'role' => 1, // Admin
                'is_admin' => true
            ],
            [
                'first_name' => 'Captain',
                'last_name' => 'Molina',
                'middle_name' => null,
                'email' => 'captain@brgy419.com',
                'password' => bcrypt('password'),
                'role' => 2, // Captain
                'is_admin' => true
            ],
            [
                'first_name' => 'Brgy',
                'last_name' => 'Official',
                'middle_name' => null,
                'email' => 'official@brgy419.com',
                'password' => bcrypt('password'),
                'role' => 3, // Official
                'is_admin' => true
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}