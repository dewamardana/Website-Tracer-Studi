<?php

namespace App\Http\Controllers;

use App\Models\answerDetail;
use App\Models\Form;
use App\Models\Jawaban;
use App\Models\Questions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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


        $jawaban = Jawaban::create([
            'kategori_id' => $request->kategori_id,
            'user_id' => $user->id,
            'form_id' => $request->form_id,
        ]);
        
        foreach ($request->input('answers') as $questionId => $answer) {
            if (is_array($answer)) {
                // Handle multiple answers (e.g., checkboxes)
                foreach ($answer as $value) {
                    answerDetail::create([
                        'jawaban_id' => $jawaban->id,
                        'question_id' => $questionId,
                        'answer' => $value,
                    ]);
                }
            } else {
                // Handle single answer
                answerDetail::create([
                    'jawaban_id' => $jawaban->id,            
                    'question_id' => $questionId,
                    'answer' => $answer,
                ]);
            }
        }

        return redirect()->route('showKategori', ['kategori' => $form->kategori_id]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $form = Form::with('questions')->findOrFail($jawaban->id);;
        $form = Form::findOrFail($id);
        $questions = Questions::where('form_id', $id)->get();

        return view('homepage.answer', [
            'title' => $form->nama,
            'form' => $form,
            'questions' => $questions,
        ]);
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
}
