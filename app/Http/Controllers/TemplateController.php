<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Kategori;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori= Kategori::all();
        return view('dashboard.template.create',[
            'title' => 'Template Create',
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
            'nama' => 'required|unique:templates|string|max:255',
            'questions' => 'required|array',
            'questions.*.question' => 'required|string',
            'questions.*.type' => 'required|string',

        ]);

        $form = Template::create([
            'nama' => $request->nama,
            'kategori_id' => $request->kategori_id,
            'user_id' => $user->id
        ]);

        foreach ($request->questions as $question) {
            $form->questions()->create($question);
        }

        return redirect()->route('templateDetail', ['kategori' => $request->kategori_id])->with('success', 'Template Berhasil Dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Template $template)
    {
        $template = Template::with('questions')->findOrFail($template->id);

        return view('dashboard.template.show', compact('template'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Template $template)
    {
        $kategori = Kategori::all();
        return view('dashboard.template.edit',[
            'title' => 'edit',
            'kategori' => $kategori,
            'template' => $template
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Template $template)
    {
        $user = Auth::user();
    
        // Validasi input
        $request->validate([
            'kategori_id' => 'required|numeric',
            'nama' => 'required|string|max:255',
            'questions' => 'required|array',
            'questions.*.question' => 'required|string',
            'questions.*.type' => 'required|string',
        ]);

        // Temukan form yang akan diperbarui
        $form = Template::findOrFail($template->id);

        // Pastikan hanya user yang membuat form yang dapat memperbarui
        if ($form->user_id !== $user->id) {
            return redirect()->back()->with('error', 'You do not have permission to edit this form.');
        }

        // Perbarui informasi form
        $form->update([
            'nama' => $request->nama,
            'kategori_id' => $request->kategori_id,
        ]);

        // Hapus pertanyaan yang ada
        $form->questions()->delete();

        // Tambahkan pertanyaan baru
        foreach ($request->questions as $question) {
            $form->questions()->create($question);
        }
        return redirect()->route('templateDetail', ['kategori' => $request->kategori_id])->with('success', 'Template Berhasil Diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Template $template)
    {
        $kategori = $template->kategori_id;
        DB::table('questions')->where('template_id', $template->id)->delete();
        DB::table('templates')->where('id', $template->id)->delete();

        return redirect()->back()->with('success', 'Template Berhasil Dihapus.');
    }


    public function checkAndRedirect($id)
    {
        // Cek apakah tabel template sudah berisi data
        $templateExists = Form::where('template_id', $id)->first();

        if ($templateExists) {
               
                return redirect()->back()->with([
                'showModal' => true,
                'modalTitle' => 'Template ini Sudah berisi data',
                'modalMessage' => 'Tekan OK untuk Membuat Duplikasi Template',
                'id' => $id,
            ]);
        } else {
            return redirect()->action([TemplateController::class, 'edit'], ['template' => $id]);
        }
    }


    public function duplicates($id)
    {
        // Cek apakah tabel template sudah berisi data
         $kategori = Kategori::all();
        $template = Template::findOrFail($id);
            return view('dashboard.template.editTemplate',[
                'title' => 'edit',
                'kategori' => $kategori,
                'template' => $template
            ]);
    }

    public function pilihTemplate()
    {
        // Cek apakah tabel template sudah berisi data
        $template = Template::all();
            return view('dashboard.template.copy',[
                'title' => 'Salin Template',
                'template' => $template,
                'back' => false,
            ]);
    }

    public function copyTemplate($id)
    {
        $template = Template::findOrFail($id);
        $kategori = Kategori::all();
        
        return view('dashboard.template.copyTemplate',[
            'title' => 'Salin Template',
            'kategori' => $kategori,
            'template' => $template
        ]);
    }
        
}



