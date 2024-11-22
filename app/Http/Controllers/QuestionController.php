<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function makeQuetion()
    {
        return view('dashboard.question.create',[
            'title' => 'Buat Pertanyaan',
        ]);
    }
}
