<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Kategori;
use App\Models\Template;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return view('homepage.index',[
            'title' => 'Homepage',
            'kategori' => $kategori,
        ]);
    }

    public function show($KategoriId)
    {   
        $template = Template::where('kategori_id', $KategoriId)->get();
        $title = Kategori::where('id', $KategoriId)->first();
        return view('homepage.detail',[
            'template' => $template,
            'title' =>$title->nama
        ]);
    }

    public function form($templateId)
    {   
        $form = Form::where('template_id', $templateId)->get();
        $title = Template::where('id', $templateId)->first();
        return view('homepage.form',[
            'form' => $form,
            'title' =>$title->nama
        ]);
    }

}
