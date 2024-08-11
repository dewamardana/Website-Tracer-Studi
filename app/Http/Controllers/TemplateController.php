<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $template = Template::all();
        return view('dashboard.template.index',[
            'title' => 'Template',
            'user' => $user->name,
            'template' => $template,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.template.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
        'nama' => 'required|unique:templates|max:100',
        'deskripsi' => 'required',
    ]);

        $validated['user_id'] = $user->id;

        DB::table('templates')->insert($validated);
        return redirect('/dashboard/template')->with('status', 'Template Surat Berhasil Dibuat');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Template $template)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Template $template)
    {
        return view('dashboard.template.edit',[
            'title' => 'edit',
            'template' => $template
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Template $template)
    {
        $user = Auth::user();
        $validated = $request->validate([
        'nama' => 'required|max:100',
        'deskripsi' => 'required',
    ]);

        $validated['user_id'] = $user->id;

        $validasinama = Template::where('id', '!=', $template->id)//yang id-nya tidak sama dengan $id
                                ->where('nama', $request->nama)
                                ->first();
        if ($validasinama) {
            return back()->with('error', 'Slug sudah ada, coba yang lain');
        } else {
            DB::table('templates')->where('id', $template->id)->update($validated);
            return redirect('/dashboard/template')->with('status', 'Template Surat Berhasil Diedit'); 
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Template $template)
    {
        DB::table('templates')->where('id', $template->id)->delete();
        return redirect('/dashboard/template')->with('status', 'Template Surat Berhasil Dihapus');
    }
}
