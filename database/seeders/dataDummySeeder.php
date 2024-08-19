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
        // Templates
        $kategoris = [
            ['nama' => 'Formulir Fakultas Teknik', 'deskripsi' => 'Berisi Seluruh Template Yang digunakan di Fakultas Teknik', 'user_id' => 1],
            ['nama' => 'Formulir Fakultas MIPA', 'deskripsi' => 'Berisi Seluruh Template Yang digunakan di Fakultas MIPA', 'user_id' => 2],
            ['nama' => 'Formulir Fakultas Kedokteran', 'deskripsi' => 'Berisi Seluruh Template Yang digunakan di Fakultas Kedokteran', 'user_id' => 3],
            ['nama' => 'Formulir Fakultas Pertanian', 'deskripsi' => 'Berisi Seluruh Template Yang digunakan di Fakultas Pertanian', 'user_id' => 4],
            ['nama' => 'Formulir Fakultas Peternakan', 'deskripsi' => 'Berisi Seluruh Template Yang digunakan di Fakultas Peternakan', 'user_id' => 1],
            ['nama' => 'Formulir Fakultas Hukum', 'deskripsi' => 'Berisi Seluruh Template Yang digunakan di Fakultas Hukum', 'user_id' => 2],
        ];

        // Insert templates
        $kategoriIds = [];
        foreach ($kategoris as $kategori) {
            $kategoriIds[] = DB::table('kategoris')->insertGetId($kategori);
        }

        // Forms and Questions
        $formsAndQuestions = [
            ['kategori_id' => $kategoriIds[0], 'forms' => [
                ['nama' => 'Form Teknik A', 'user_id' => 1],
                ['nama' => 'Form Teknik B', 'user_id' => 1],
                ['nama' => 'Form Teknik C', 'user_id' => 2],
                ['nama' => 'Form Teknik D', 'user_id' => 2],
            ]],
            ['kategori_id' => $kategoriIds[1], 'forms' => [
                ['nama' => 'Form MIPA A', 'user_id' => 3],
                ['nama' => 'Form MIPA B', 'user_id' => 3],
                ['nama' => 'Form MIPA C', 'user_id' => 4],
                ['nama' => 'Form MIPA D', 'user_id' => 4],
            ]],
            ['kategori_id' => $kategoriIds[2], 'forms' => [
                ['nama' => 'Form Kedokteran A', 'user_id' => 1],
                ['nama' => 'Form Kedokteran B', 'user_id' => 1],
                ['nama' => 'Form Kedokteran C', 'user_id' => 2],
                ['nama' => 'Form Kedokteran D', 'user_id' => 2],
            ]],
            ['kategori_id' => $kategoriIds[3], 'forms' => [
                ['nama' => 'Form Pertanian A', 'user_id' => 3],
                ['nama' => 'Form Pertanian B', 'user_id' => 3],
                ['nama' => 'Form Pertanian C', 'user_id' => 4],
                ['nama' => 'Form Pertanian D', 'user_id' => 4],
            ]],
            ['kategori_id' => $kategoriIds[4], 'forms' => [
                ['nama' => 'Form Peternakan A', 'user_id' => 1],
                ['nama' => 'Form Peternakan B', 'user_id' => 1],
                ['nama' => 'Form Peternakan C', 'user_id' => 2],
                ['nama' => 'Form Peternakan D', 'user_id' => 2],
            ]],
            ['kategori_id' => $kategoriIds[5], 'forms' => [
                ['nama' => 'Form Hukum A', 'user_id' => 3],
                ['nama' => 'Form Hukum B', 'user_id' => 3],
                ['nama' => 'Form Hukum C', 'user_id' => 4],
                ['nama' => 'Form Hukum D', 'user_id' => 4],
            ]],
        ];

        foreach ($formsAndQuestions as $formsAndQuestionsSet) {
            $formIds = [];
            foreach ($formsAndQuestionsSet['forms'] as $form) {
                $formIds[] = DB::table('forms')->insertGetId([
                    'nama' => $form['nama'],
                    'kategori_id' => $formsAndQuestionsSet['kategori_id'],
                    'user_id' => $form['user_id']
                ]);
            }

            foreach ($formIds as $formId) {
                // Add some example questions
                DB::table('questions')->insert([
                    ['form_id' => $formId, 'question' => 'What is your name?', 'type' => 'text', 'options' => null, 'required' => true],
                    ['form_id' => $formId, 'question' => 'Do you have a degree?', 'type' => 'radio', 'options' => json_encode(['Yes', 'No']), 'required' => true],
                    ['form_id' => $formId, 'question' => 'Select your department', 'type' => 'dropdown', 'options' => json_encode(['Engineering', 'Science', 'Medicine']), 'required' => true],
                    ['form_id' => $formId, 'question' => 'Which courses did you take?', 'type' => 'checkbox', 'options' => json_encode(['Math', 'Science', 'English']), 'required' => false],
                    ['form_id' => $formId, 'question' => 'Additional Comments', 'type' => 'textarea', 'options' => null, 'required' => false],
                ]);
            }
        }
    }
}
