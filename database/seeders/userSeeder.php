<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class userSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Mardana',
                'email' => 'mardana305@gmail.com',
                'password' => Hash::make('123456789'),
                'role' => ['admin'], // Role sebagai array
            ],
            [
                'name' => 'Lecturer User',
                'email' => 'lecturer@example.com',
                'password' => Hash::make('password123'),
                'role' => ['dosen'], // Role sebagai array
            ],
            [
                'name' => 'Student User 1',
                'email' => 'student1@example.com',
                'password' => Hash::make('password123'),
                'role' => ['mahasiswa'], // Role sebagai array
            ],
            [
                'name' => 'Student User 2',
                'email' => 'student2@example.com',
                'password' => Hash::make('password123'),
                'role' => ['mahasiswa'], // Role sebagai array
            ],
        ];

        // Insert users into the database
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
