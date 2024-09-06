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

    public function show(Kategori $kategori)
    {   
        $template = Template::where('kategori_id', $kategori->id)->get();
        $data = Kategori::where('id', $kategori->id)->first();
        return view('homepage.detail',[
            'template' => $template,
            'title' => $data->nama,
            
            
        ]);
    }

    public function form(Template $template)
    {   
        $form = Form::where('template_id', $template->id)->get();
        $data = Template::where('id', $template->id)->first();
        return view('homepage.form',[
            'form' => $form,
            'title' =>$data->nama,
            'kategori' => $data->kategori->slug
        ]);
    }

}
