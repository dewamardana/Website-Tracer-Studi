<?php

namespace Database\Seeders;

<<<<<<< HEAD
=======
use App\Models\User;
>>>>>>> 250ab6d41aa9fde7ed758faa268346ec9e2b0f5b
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class userSeeder extends Seeder
{
    public function run()
    {
<<<<<<< HEAD
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
=======
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
>>>>>>> 250ab6d41aa9fde7ed758faa268346ec9e2b0f5b
    }
}
