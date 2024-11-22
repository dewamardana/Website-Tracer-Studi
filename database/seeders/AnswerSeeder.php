<?php

namespace Database\Seeders;

use App\Models\Jawaban;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mendapatkan ID jawaban yang telah ada
        $jawabanIds = DB::table('jawabans')->pluck('id')->toArray();

        // Mendapatkan ID formulir dan pertanyaan
        $questions = DB::table('questions')->get();

        // Mengisi detail jawaban
        foreach ($questions as $question) {
            foreach ($jawabanIds as $jawabanId) {
                // Menentukan jawaban contoh untuk setiap jenis pertanyaan
                $answer = '';
                if ($question->type == 'text') {
                    $answer = 'Contoh Nama';
                } elseif ($question->type == 'radio') {
                    $answer = 'Yes'; // Asumsi jawaban untuk radio
                } elseif ($question->type == 'dropdown') {
                    $answer = 'Engineering'; // Asumsi jawaban untuk dropdown
                } elseif ($question->type == 'checkbox') {
                    $answer = json_encode(['Math', 'Science']); // Asumsi jawaban untuk checkbox
                } elseif ($question->type == 'textarea') {
                    $answer = 'Contoh komentar tambahan';
                }

                DB::table('answer_details')->insert([
                    'question_id' => $question->id,
                    'answer' => $answer,
                    'jawaban_id' => $jawabanId,
                ]);
            }
        }
    }    
    
}
