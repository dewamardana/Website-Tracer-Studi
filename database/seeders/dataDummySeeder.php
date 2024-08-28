<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class dataDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
                // Kategoris
        $kategoris = [
            ['nama' => 'Mahasiswa', 'deskripsi' => 'Formulir untuk Mahasiswa', 'user_id' => 1],
            ['nama' => 'Dosen', 'deskripsi' => 'Formulir untuk Dosen', 'user_id' => 2],
            ['nama' => 'Karyawan', 'deskripsi' => 'Formulir untuk Karyawan', 'user_id' => 3],
            ['nama' => 'Alumni', 'deskripsi' => 'Formulir untuk Alumni', 'user_id' => 4],
        ];

        // Insert kategoris
        $kategoriIds = [];
        foreach ($kategoris as $kategori) {
            $kategoriIds[] = DB::table('kategoris')->insertGetId($kategori);
        }

        // Forms
        $forms = [
            ['kategori_id' => $kategoriIds[0], 'templates' => [
                ['nama' => 'Formulir Pendaftaran Mahasiswa Baru', 'user_id' => 1],
                ['nama' => 'Formulir Perubahan Data Mahasiswa', 'user_id' => 1],
                ['nama' => 'Formulir Pengajuan Beasiswa', 'user_id' => 2],
            ]],
            ['kategori_id' => $kategoriIds[1], 'templates' => [
                ['nama' => 'Formulir Pengajuan Cuti Mengajar', 'user_id' => 2],
                ['nama' => 'Formulir Evaluasi Kinerja Dosen', 'user_id' => 2],
            ]],
            ['kategori_id' => $kategoriIds[2], 'templates' => [
                ['nama' => 'Formulir Permohonan Cuti', 'user_id' => 3],
                ['nama' => 'Formulir Evaluasi Kinerja Karyawan', 'user_id' => 3],
            ]],
            ['kategori_id' => $kategoriIds[3], 'templates' => [
                ['nama' => 'Formulir Update Informasi Alumni', 'user_id' => 4],
                ['nama' => 'Formulir Permohonan Sertifikat Alumni', 'user_id' => 4],
            ]],
        ];

        // Insert forms
        foreach ($forms as $formSet) {
            foreach ($formSet['templates'] as $form) {
                DB::table('templates')->insert([
                    'nama' => $form['nama'],
                    'kategori_id' => $formSet['kategori_id'],
                    'user_id' => $form['user_id']
                ]);
            }
        }

            // foreach ($formIds as $formId) {
            //     // Add some example questions
            //     DB::table('questions')->insert([
            //         ['form_id' => $formId, 'question' => 'What is your name?', 'type' => 'text', 'options' => null, 'required' => true],
            //         ['form_id' => $formId, 'question' => 'Do you have a degree?', 'type' => 'radio', 'options' => json_encode(['Yes', 'No']), 'required' => true],
            //         ['form_id' => $formId, 'question' => 'Select your department', 'type' => 'dropdown', 'options' => json_encode(['Engineering', 'Science', 'Medicine']), 'required' => true],
            //         ['form_id' => $formId, 'question' => 'Which courses did you take?', 'type' => 'checkbox', 'options' => json_encode(['Math', 'Science', 'English']), 'required' => false],
            //         ['form_id' => $formId, 'question' => 'Additional Comments', 'type' => 'textarea', 'options' => null, 'required' => false],
            //     ]);
            // }
        
    }
}
