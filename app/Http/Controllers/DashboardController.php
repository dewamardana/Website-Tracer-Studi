<?php

namespace App\Http\Controllers;

use App\Models\Form;
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
        $template = Template::all();
        return view('dashboard.form.menu',[
            'title' => 'Form Template',
            'user' => $user->name,
            'template' => $template,
        ]);
    }

    public function templateForm($templateId)
    {
        $user = Auth::user();
        $template = Template::findOrFail($templateId);
        $forms = Form::where('template_id', $template->id)
                     ->where('user_id', $user->id)
                     ->get();

        return view('dashboard.form.index', [
            'title' => 'Form', 
            'form' => $forms,
            'user' => $user->name,
            'template' => $template
        ]);
    }
    
}
