<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Kategori;
use App\Models\Questions;
use App\Models\Template;
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
        // $user = Auth::user();
        // $form = Form::where('user_id', $user->id)->get();
        // return view('dashboard.form.index',[
        //     'title' => 'Form', 
        //     'user' => $user->name,
        //     'form' => $form,
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori= Kategori::all();
        return view('dashboard.form.create',[
            'title' => 'Form Create',
            'kategori' => $kategori,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([ 
            'kategori_id' => 'required|numeric',
            'form_title_main' => 'required|string|max:255',
            'questions' => 'required|array',
            'questions.*.question' => 'required|string',
            'questions.*.type' => 'required|string',

        ]);

        $form = Form::create([
            'nama' => $request->form_title_main,
            'kategori_id' => $request->kategori_id,
            'user_id' => $user->id
        ]);

        foreach ($request->questions as $question) {
            $form->questions()->create($question);
        }

        return redirect()->route('formDetail', ['kategori' => $request->kategori_id])->with('success', 'Template Berhasil Dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Form $form)
    {
        $form = Form::with('questions')->findOrFail($form->id);

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
        $kategori = $form->kategori_id;
        DB::table('questions')->where('form_id', $form->id)->delete();
        DB::table('forms')->where('id', $form->id)->delete();

        return redirect()->route('formDetail', ['kategori' => $kategori])->with('success', 'Template Berhasil Dihapus.');
    }

    public function copyTemplate(){
        $kategori = Kategori::all();
        return view('dashboard.form.copy',[
            'title' => 'Buat Template',
            'kategori' => $kategori
        ]);
    }


    public function checkAndRedirect($id)
    {
        // Cek apakah template dengan id tertentu sudah ada
        $template = Template::find($id);

        if ($template) {
            // // Jika template sudah ada, berikan peringatan dan buat duplikat
            // $newTemplate = $template->replicate(); // Menggandakan template
            // $newTemplate->save(); // Menyimpan duplikat dengan id baru
            
            // Redirect ke halaman edit template baru dengan pesan peringatan
            return redirect()->with('warning', 'Template sudah ada.');
        } else {
            // Jika template belum ada, arahkan ke halaman edit
            return redirect()->route('editTemplate', ['id' => $id]);
        }
    }
}
