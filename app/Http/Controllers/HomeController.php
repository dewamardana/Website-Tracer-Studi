<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Template;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $template = Template::all();
        return view('homepage.index',[
            'title' => 'Homepage',
            'template' => $template,
        ]);
    }

    public function show($templateId)
    {   
        $form = Form::where('template_id', $templateId)->get();
        $title = Template::where('id', $templateId)->first();
        return view('homepage.detail',[
            'title' => $title->nama,
            'form' => $form,
        ]);
    }

}
