<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\User;
use App\Models\Template;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Formseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil beberapa user dan template sebagai referensi
        $users = User::all();
        $templates = Template::all();

        // Membuat beberapa contoh data form
        foreach ($users as $user) {
            foreach ($templates as $template) {
                Form::create([
                    'nama' => 'Form ' . $template->nama,
                    'template_id' => $template->id,
                    'user_id' => $user->id,
                    'tahun_ajaran' => now()->year,
                    'open' => now(),
                    'close' => now()->addDays(10),
                ]);
            }
        }
    }
}
