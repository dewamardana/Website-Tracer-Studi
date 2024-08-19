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
        return view('dashboard.form.menu',[
            'title' => 'Form Kategori',
            'user' => $user->name,
            'kategori' => $kategori,
        ]);
    }

    public function kategoriForm($kategoriId)
    {
        $user = Auth::user();
        $kategori = Kategori::findOrFail($kategoriId);
        $forms = Form::where('kategori_id', $kategori->id)
                     ->where('user_id', $user->id)
                     ->get();

        return view('dashboard.form.index', [
            'title' => 'Form', 
            'form' => $forms,
            'user' => $user->name,
            'kategori' => $kategori
        ]);
    }
    
}
