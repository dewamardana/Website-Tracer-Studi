<?php

namespace Database\Seeders;

use App\Models\Jawaban;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RolesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            dataDummySeeder::class,
            // JawabanSeeder::class,
            // FormSeeder::class,
            AnswerSeeder::class,
        ]);
    }
}
