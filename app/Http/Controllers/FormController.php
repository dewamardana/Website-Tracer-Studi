<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Template;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        $form = Form::all();
        return view('dashboard.form.index',[
            'title' => 'Form',
            'user' => $user,
            'form' => $form
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $template= Template::all();
        return view('dashboard.form.create',[
            'title' => 'Form Create',
            'template' => $template,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([ 
            'nama' => 'required|unique:forms|string|max:255',
            'template_id' => 'required',
            'tahun_ajaran' => 'required|numeric',
            'open' => 'required|date',
            'close' => 'required|date',
        ]);

        $slug = Str::of($request->nama)->slug('-');

        $validated['slug'] = $slug;
        $validated['user_id'] = $user->id;
        $validated['tautan'] = 'http://pkl-project.test:8080/detail/answer/'. $slug;
        DB::table('forms')->insert($validated);
        return redirect('/dashboard/form')->with('success', 'Formulir Berhasil Dibuat');


        
    }

    /**
     * Display the specified resource.
     */
    public function show(Form $form)
    {
        $form = Form::findOrFail($form->id);

        return view('dashboard.form.show', compact('form'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Form $form)
    {
        $user = Auth::user();
        if ($form->user_id !== $user->id) {
            return back()->with('warning', 'Tidak Bisa Menghapus Formulir Pengguna Lain');
        }
        
        $kategori = Kategori::all();
        $template = Template::all();
        return view('dashboard.form.edit',[
            'title' => 'edit',
            'kategori' => $kategori,
            'form' => $form,
            'template' => $template
        ]);
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, Form $form)
    {
        $user = Auth::user();


        $validated = $request->validate([ 
            'nama' => 'required|string|max:255',
            'template_id' => 'required',
            'tahun_ajaran' => 'required|numeric',
            'open' => 'required|date',
            'close' => 'required|date',
        ]);

        // Pastikan hanya user yang membuat form yang dapat memperbarui
        if ($form->user_id != $user->id) {
            return redirect('/dashboard/form')->with('warning', 'Tidak Bisa Mengubah Template Pengguna Lain');
        }

        $validated['user_id'] = $user->id;
        

        $slug = Str::of($request->nama)->slug('-');
        $validated['slug'] = $slug;
        $validated['tautan'] = 'http://pkl-project.test:8080/detail/answer/'. $slug;
        
        $validasi = Form::where('id', '!=', $form->id)//yang id-nya tidak sama dengan $id
                                ->where('nama', $request->nama)
                                ->first();
        if ($validasi) {
            return back()->with('warning', 'Nama sudah ada, coba yang lain');
        } else {
            DB::table('forms')->where('id', $form->id)->update($validated);
            return redirect('/dashboard/form')->with('success', 'Formulir Berhasil Diedit');
        }
        
        
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {
        $user = Auth::user();
        if ($form->user_id !== $user->id) {
            return back()->with('warning', 'Tidak Bisa Menghapus Formulir Pengguna Lain');
        }

        try {
            DB::table('forms')->where('id', $form->id)->delete();
            return redirect('/dashboard/form')->with('success', 'Formilir Berhasil Dihapus');
        } catch (\Exception $e) {
            // Jika gagal, redirect dengan pesan error
             return redirect('/dashboard/form')->with('warning', 'Formilir gagal Dihapus karena Sudah berisi Data');
        }
    }

}
