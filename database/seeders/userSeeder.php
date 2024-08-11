<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class userSeeder extends Seeder
{
    public function run()
    {
        // Daftar users
        $users = [
            [
                'role_id' => 1, // Admin
                'name' => 'Mardana',
                'email' => 'dewamardana@gmail.com',
                'password' => Hash::make('123456789'),
            ],
            [
                'role_id' => 2, // Lecturer
                'name' => 'Lecturer User',
                'email' => 'lecturer@example.com',
                'password' => Hash::make('password123'),
            ],
            [
                'role_id' => 3, // Student/Alumni
                'name' => 'Student User',
                'email' => 'student@example.com',
                'password' => Hash::make('password123'),
            ],
            [
                'role_id' => 1, // Admin
                'name' => 'Another Admin',
                'email' => 'anotheradmin@example.com',
                'password' => Hash::make('password123'),
            ],
        ];

        // Insert users
        DB::table('users')->insert($users);
    }
}
