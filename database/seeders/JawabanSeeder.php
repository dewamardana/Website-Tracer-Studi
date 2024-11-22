<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JawabanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mengambil ID user
        $users = DB::table('users')->pluck('id')->toArray();

        // Mendapatkan ID formulir yang telah ada
        $formIds = DB::table('forms')->pluck('id')->toArray();

        // Menyimpan jawaban untuk setiap formulir
        foreach ($formIds as $formId) {
            foreach ($users as $userId) {
                DB::table('jawabans')->insert([
                    'kategori_id' => DB::table('forms')->where('id', $formId)->value('kategori_id'),
                    'user_id' => $userId,
                    'form_id' => $formId,
                ]);
            }
        }
    }
}
