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
        $form = Form::where('kategori_id', $KategoriId)->get();
        $title = Kategori::where('id', $KategoriId)->first();
        return view('homepage.detail',[
            'title' => $title->nama,
            'form' => $form,
        ]);
    }

}
