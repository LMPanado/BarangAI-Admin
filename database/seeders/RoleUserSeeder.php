<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    $users = [
        [
            'name' => 'System Admin',
            'email' => 'admin@brgy419.com',
            'password' => bcrypt('password'),
            'role' => 1,
            'is_admin' => true
        ],
        [
            'name' => 'Brgy Captain Molina',
            'email' => 'captain@brgy419.com',
            'password' => bcrypt('password'),
            'role' => 2,
            'is_admin' => true
        ],
        [
            'name' => 'Brgy Official',
            'email' => 'official@brgy419.com',
            'password' => bcrypt('password'),
            'role' => 3,
            'is_admin' => true
        ],
    ];

    foreach ($users as $user) {
        \App\Models\User::create($user);
    }
}
}