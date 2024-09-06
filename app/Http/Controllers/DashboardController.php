<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Kategori;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index',[
            'title' => 'Form' 
        ]);
    }

    public function mainPage()
    {
        $user = Auth::user();
        $kategori = Kategori::all();
        return view('dashboard.template.menu',[
            'title' => 'Template Kategori',
            'user' => $user->name,
            'kategori' =>$kategori,
        ]); 
    }

    public function TemplatePage(Kategori $kategori)
    {
        $user = Auth::user();
        $template = Template::where('kategori_id',$kategori->id)->get();

        return view('dashboard.template.index', [
            'title' => 'Template', 
            'template' => $template,
            'user' => $user->name,
            'kategori' =>$kategori,
        ]);
    }
    
}
