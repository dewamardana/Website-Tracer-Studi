<?php

namespace App\Http\Controllers;

use App\Models\answerDetail;
use App\Models\Form;
use App\Models\Jawaban;
use App\Models\Questions;
use App\Models\SectionDump;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Question\Question;

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

        if($jawaban->nowSection == $jawaban->maxSection){
            $jawaban->nowSection += 1;
            $jawaban->save();
            return redirect()->route('showForm', ['template' => $form->template->slug])->with('success', 'Formulir sudah Diisi');
        }else{
            // Update 'nowSection' untuk section berikutnya
            $jawaban->nowSection += 1;
            $jawaban->save();
            // Redirect ke pertanyaan berikutnya
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
        }else if($jawaban->nowSection > $jawaban->maxSection){
            return redirect()->route('showForm', ['template' => $form->template->slug])->with('warning', 'Anda Sudah Mengisi Form ini');
        }else{
            $section = $jawaban->nowSection;
            $btnMessage = $section == $jawaban->maxSection ? 'Finish' : 'Next';

        }
        // Ambil pertanyaan untuk section saat ini
        $questions = Questions::where('template_id', $form->template_id)
                            ->where('section', $section)
                            ->get();

        return view('homepage.answer', [
            'title' => $form->nama,
            'form' => $form,
            'questions' => $questions,
            'btnMessage' => $btnMessage,
            'section' => $section,
        ]);
    }

    
}
