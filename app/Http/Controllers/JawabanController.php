<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Jawaban;
use App\Models\Questions;
use App\Models\SectionDump;
use App\Models\answerDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Query\Builder;

class JawabanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $form = Form::findOrFail($request->form_id);
        
        $jawaban = Jawaban::where('form_id', $request->form_id)
                        ->where('template_id', $request->template_id)
                        ->where('user_id', $user->id)->first();
        // Cek apakah section pertama, buat 'jawaban' baru jika iya
        if (!$jawaban) {
            $max = DB::table('questions')->where('template_id', $request->template_id)->max('section');
            $jawaban = Jawaban::create([
                'template_id' => $request->template_id,
                'user_id' => $user->id,
                'form_id' => $request->form_id, 
                'nowSection' => $request->section,
                'maxSection' => $max,
            ]);
        }
            
            // Simpan jawaban detail
        foreach ($request->input('answers') as $questionId => $answer) {
            if (is_array($answer)) {
                foreach ($answer as $value) {
                    answerDetail::create([
                        'jawaban_id' => $jawaban->id,
                        'question_id' => $questionId,
                        'answer' => $value,
                    ]);
                }
            } else {
                answerDetail::create([
                    'jawaban_id' => $jawaban->id,
                    'question_id' => $questionId,
                    'answer' => $answer,
                ]);
            }
        }
        // Ambil answer_detail untuk jawaban yang sudah ada
        $answer_details = AnswerDetail::where('jawaban_id', $jawaban->id)->get();
        $cekQuestion = Questions::where('template_id', $form->template_id)
                              ->where('section', $jawaban->nowSection)
                              ->where(function ($query) use ($answer_details) {
                                  // Tampilkan pertanyaan yang tidak ada requirement-nya
                                  $query->whereNull('question_requirment');

                                  // Tampilkan pertanyaan yang memenuhi syarat question_requirment
                                  foreach ($answer_details as $answer_detail) {
                                      $query->orWhere(function ($subQuery) use ($answer_detail) {
                                          $subQuery->where('question_requirment', $answer_detail->question_id)
                                                   ->where('question_requirment_value', $answer_detail->answer);
                                      });
                                  }
                              })->whereNotIn('id', $answer_details->pluck('question_id'))->get(); // Menambahkan kondisi untuk hanya mengambil pertanyaan yang belum terjawab
                            
        if($cekQuestion->isEmpty()){
            if($jawaban->nowSection == $jawaban->maxSection){
                $jawaban->nowSection += 1;
                $jawaban->save();
                return redirect()->route('showForm', ['template' => $form->template->slug])->with('success', 'Formulir sudah Diisi');
            }else{
                $jawaban->nowSection += 1;
                $jawaban->save();

                return redirect()->action(
                    [JawabanController::class, 'showQuestion'], ['form' => $form->slug]
                );
            }
        }else{
            return redirect()->action(
                [JawabanController::class, 'showQuestion'], ['form' => $form->slug]
            );
        }          
    }
       
    
        
    /**
     * Display the specified resource.
     */
    public function show(Form $form)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jawaban $jawaban)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jawaban $jawaban)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jawaban $jawaban)
    {
        //
    }

    public function showQuestion(Form $form)
    {
        $user = Auth::user();
        if (Carbon::now()->lt($form->open)) {
            // Tanggal sekarang lebih kecil dari tanggal open, artinya form belum dibuka
            return redirect()->route('showForm', ['template' => $form->template->slug])->with('warning', 'Form belum dibuka.');
        } elseif (Carbon::now()->gt($form->close)) {
            // Tanggal sekarang lebih besar dari tanggal close, artinya form sudah ditutup
            return redirect()->route('showForm', ['template' => $form->template->slug])->with('error', 'Form sudah ditutup.');
        } else {

            // Cek dan update nilai section saat ini dan max section

            $jawaban = Jawaban::where('form_id', $form->id)
                                ->where('template_id', $form->template_id)
                                ->where('user_id', $user->id)->first();

            // Jika section pertama kali, inisialisasi section dan maxSection

            $btnMessage = '';
            $section = 0;

            if(!$jawaban) {
                $section = 1;
                $btnMessage = 'Next';
                $questions = Questions::where('template_id', $form->template_id)
                                    ->where('section', $section)
                                    ->whereNull('question_requirment')
                                    ->get();
            }else if($jawaban->nowSection > $jawaban->maxSection){
                return redirect()->route('showForm', ['template' => $form->template->slug])->with('warning', 'Anda Sudah Mengisi Form ini');
            }else{
                $section = $jawaban->nowSection;
                $btnMessage = $section == $jawaban->maxSection ? 'Finish' : 'Next';
                // Ambil answer_detail untuk jawaban yang sudah ada
                $answer_details = AnswerDetail::where('jawaban_id', $jawaban->id)->get();

                // Ambil pertanyaan dengan memperhatikan question_requirment
                $questions = Questions::where('template_id', $form->template_id)
                                ->where('section', $section)
                                ->where(function ($query) use ($answer_details) {
                                    // Tampilkan pertanyaan yang tidak ada requirement-nya
                                    $query->whereNull('question_requirment');

                                    // Tampilkan pertanyaan yang memenuhi syarat question_requirment
                                    foreach ($answer_details as $answer_detail) {
                                        $query->orWhere(function ($subQuery) use ($answer_detail) {
                                            $subQuery->where('question_requirment', $answer_detail->question_id)
                                                    ->where('question_requirment_value', $answer_detail->answer);
                                        });
                                    }
                                })->whereNotIn('id', $answer_details->pluck('question_id'))->get(); // Menambahkan kondisi untuk hanya mengambil pertanyaan yang belum terjawab
            }

            if($questions->isEmpty()){
                $max = DB::table('questions')->where('template_id', $form->template_id)->max('section');
                if(!$jawaban){
                    while($questions->isEmpty() && $section <= $max){
                        $questions = Questions::where('template_id', $form->template_id)
                                    ->where('section', $section)
                                    ->whereNull('question_requirment')
                                    ->get();
                        if($questions->isEmpty()){
                            $section += 1;
                        }
                    }
                }else{
                    $jawaban->nowSection += 1;
                    $jawaban->save();
                        return redirect()->action(
                            [JawabanController::class, 'showQuestion'], ['form' => $form->slug]
                        );
                }

                if($section > $max){
                    return redirect()->route('showForm', ['template' => $form->template->slug])->with('warning', 'Form ini Kosong, hubungi pemilik formulir');
                } 
                $section = 1;

            }
            return view('homepage.answer', [
                'title' => $form->nama,
                'form' => $form,
                'questions' => $questions,
                'btnMessage' => $btnMessage,
                'section' => $section,
            ]);
        }
    }

    
}
