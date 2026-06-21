<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'email'       => 'admin@brgy419.com',
                'first_name'  => 'System',
                'last_name'   => 'Admin',
                'middle_name' => null,
                'password'    => Hash::make('Admin@419!'),
                'role'        => 1,
                'is_admin'    => true,
            ],
            [
                'email'       => 'captain@brgy419.com',
                'first_name'  => 'Captain',
                'last_name'   => 'Molina',
                'middle_name' => null,
                'password'    => Hash::make('Captain@419!'),
                'role'        => 2,
                'is_admin'    => true,
            ],
            [
                'email'       => 'official@brgy419.com',
                'first_name'  => 'Brgy',
                'last_name'   => 'Official',
                'middle_name' => null,
                'password'    => Hash::make('Official@419!'),
                'role'        => 3,
                'is_admin'    => true,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
