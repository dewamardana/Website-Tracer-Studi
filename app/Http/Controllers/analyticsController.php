<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Kategori;
use App\Models\User;
use App\Models\Template;
use App\Models\Jawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Display analytics dashboard with filter options.
     */
    public function index(Request $request)
    {
        // Ambil data kategori untuk dropdown
        $kategori = Kategori::all();
        
        // Ambil filter dari request
        
        $tipe = $request->input('tipe');
    
        $search = $request->input('search');
        
        // Query forms dengan data analitik
        $query = DB::table('forms')
            ->leftJoin('jawabans', 'forms.id', '=', 'jawabans.form_id')
            ->select(
                'forms.id',
                'forms.nama as nama',
                'forms.tipe as kategori',
                DB::raw('COUNT(DISTINCT jawabans.user_id) as jumlah_responden')
            )
            ->groupBy('forms.id', 'forms.nama', 'forms.tipe');


            
      // Filter kategori (tipe)
    if ($tipe) {
        // Ambil semua template berdasarkan kategori_id
        $templates = Template::where('kategori_id', $tipe)->get();

        // Ambil ID template dari koleksi
        $templateIds = $templates->pluck('id'); // Mengambil ID dari koleksi template

        // Filter forms berdasarkan template_id
        $query->whereIn('forms.template_id', $templateIds);
    }

    // Filter pencarian
    if ($search) {
        $query->where('forms.nama', 'LIKE', '%' . $search . '%');
    }

    // Ambil hasil query dengan pagination
    $forms = $query->paginate(20);

    // Hitung total pengguna dan jawaban
    $jumlahUsers = User::count();
    $jumlahJawaban = DB::table('jawabans')->count();

    // Return ke view
    return view('dashboard.analytics.index', [
        'title' => 'Analytics',
        'kategori' => $kategori,
        'forms' => $forms,
        'selectedTipe' => $tipe,
        'searchQuery' => $search,
        'jumlahUsers' => $jumlahUsers,
        'jumlahJawaban' => $jumlahJawaban,
    ]);
}

    /**
     * Show detailed analytics for a specific form.
     */
    public function analyticsView($formNama)
    {
        $FetchForm = Form::where('nama', $formNama)->first();

        // Ambil detail form beserta template yang digunakan
        $form = DB::table('forms')
            ->join('templates', 'forms.template_id', '=', 'templates.id')
            ->where('forms.id', $FetchForm->id)
            ->select('forms.*', 'templates.nama as namaTemplate')
            ->first();

        $questions = DB::table('questions')
            ->where('template_id', $form->template_id)
            ->select('questions.id as q_id', 'questions.question as q_questions')
            ->get();

        $FetchUser = DB::table('users')
            ->join('jawabans', 'users.id', '=', 'jawabans.user_id') // Join dengan tabel jawabans
            ->join('answer_details', 'jawabans.id', '=', 'answer_details.jawaban_id') // Join dengan tabel answer_details
            ->where('jawabans.form_id', $FetchForm->id) // Memfilter berdasarkan form_id
            ->select('users.*', DB::raw('COUNT(answer_details.id) as answer_count')) // Menghitung jumlah answer_details
            ->groupBy('users.id') // Mengelompokkan hasil berdasarkan user
            ->get();

        $fetchJawabans = Jawaban::where('form_id', $FetchForm->id)->get();
        $fetchAnswer = collect(); // Inisialisasi koleksi jawaban
        if ($fetchJawabans->isNotEmpty()) {
            foreach ($fetchJawabans as $jawaban) {
                $answersForJawaban = DB::table('answer_details')
                    ->join('questions', 'answer_details.question_id', '=', 'questions.id')
                    ->where('jawaban_id', $jawaban->id)
                    ->select('answer_details.*', 'questions.id as question_id', 'answer_details.answer')
                    ->get();

                // Gabungkan semua jawaban ke dalam satu koleksi
                $fetchAnswer = $fetchAnswer->merge($answersForJawaban);
            }
        }

        return view('livewire.analytics', compact('FetchForm', 'questions', 'fetchAnswer', 'fetchJawabans', 'FetchUser'));
    }
}