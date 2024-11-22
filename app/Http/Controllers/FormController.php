<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Template;
use App\Models\Questions;
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
        $validated['user_id'] = $user->id;
        $validated['tautan'] = "http://pkl-project.test:8080/detail/answer/{$request->nama}";
        DB::table('forms')->insert($validated);
        return redirect('/dashboard/form')->with('status', 'Formulir Berhasil Dibuat');


        
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
        $kategori = Kategori::all();
        return view('dashboard.form.edit',[
            'title' => 'edit',
            'kategori' => $kategori,
            'form' => $form
        ]);
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, Form $form)
    {
    $user = Auth::user();
    
    // Validasi input
    $request->validate([
        'kategori_id' => 'required|numeric',
        'form_title_main' => 'required|string|max:255',
        'questions' => 'required|array',
        'questions.*.question' => 'required|string',
        'questions.*.type' => 'required|string',
    ]);

    // Temukan form yang akan diperbarui
    $form = Form::findOrFail($form->id);

    // Pastikan hanya user yang membuat form yang dapat memperbarui
    if ($form->user_id !== $user->id) {
        return redirect()->back()->with('error', 'You do not have permission to edit this form.');
    }

    // Perbarui informasi form
    $form->update([
        'nama' => $request->form_title_main,
        'kategori_id' => $request->kategori_id,
        'tautan' => "http://pkl-project.test:8080/detail/answer/{$request->nama}",
    ]);

    // Hapus pertanyaan yang ada
    $form->questions()->delete();

    // Tambahkan pertanyaan baru
    foreach ($request->questions as $question) {
        $form->questions()->create($question);
    }

    return redirect()->route('formDetail', ['kategori' => $request->kategori_id])->with('success', 'Template Berhasil Diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {
        DB::table('forms')->where('id', $form->id)->delete();
       return redirect('/dashboard/form')->with('status', 'Formilir Berhasil Dihapus');
    }

}
