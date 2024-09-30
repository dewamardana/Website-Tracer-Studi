<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Jawaban;
use App\Models\Kategori;
use App\Models\Template;
use Illuminate\Support\Str;
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
            'questions.*.section' => 'required|numeric',

        ]);

        // Generate the initial slug
        $slug = Str::of($request->nama)->slug('-');
        $originalSlug = $slug;

        // Check if slug already exists and modify it if necessary
        $counter = 1;
        while (DB::table('templates')->where('slug', $slug)->exists()) {
            // Add a counter to the slug if it already exists
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $form = Template::create([
            'nama' => $request->nama,
            'slug' => $slug,
            'kategori_id' => $request->kategori_id,
            'user_id' => $user->id
        ]);

        foreach ($request->questions as $question) {
            $form->questions()->create($question);
        }

        $back = Kategori::findOrFail($request->kategori_id);
        return redirect()->route('templateDetail', ['kategori' => $back->slug])->with('success', 'Template Berhasil Dibuat.');
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
        $user = Auth::user();
        // Pastikan hanya user yang membuat form yang dapat memperbarui
        if ($template->user_id !== $user->id) {
            return back()->with('warning', 'Tidak Bisa Mengubah Template Pengguna Lain');
        }
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

        $validasi = Template::where('id', '!=', $template->id)//yang id-nya tidak sama dengan $id
                                ->where('nama', $request->nama)
                                ->first();
        if ($validasi) {
            return back()->with('warning', 'Nama Template sudah ada, coba yang lain');
        } else {
            $form->update([
                'nama' => $request->nama,
                'kategori_id' => $request->kategori_id,
                'slug' => Str::of($request->nama)->slug('-'),
            ]);
        }

        // Hapus pertanyaan yang ada
        $form->questions()->delete();

        // Tambahkan pertanyaan baru
        foreach ($request->questions as $question) {
            $form->questions()->create($question);
        }

        $back = Kategori::findOrFail($request->kategori_id);
        return redirect()->route('templateDetail', ['kategori' => $back->slug])->with('success', 'Template Berhasil Diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Template $template)
    {
        $user = Auth::user();
        if ($template->user_id !== $user->id) {
            return back()->with('warning', 'Tidak Bisa Menghapus Template Pengguna Lain');
        }

        try {
            // Hapus semua pertanyaan yang terkait dengan template
            DB::table('questions')->where('template_id', $template->id)->delete();
            // Hapus template
            DB::table('templates')->where('id', $template->id)->delete();
            
            
            // Jika berhasil, redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Template berhasil dihapus.');
        } catch (\Exception $e) {
             return redirect()->back()->with('warning', 'Template Gagal dihapus karena sudah berisi data');
        }




        

       
    }


    public function checkAndRedirect(Template $template)
    {
        // Cek apakah tabel template sudah berisi data
        $templateExists = Jawaban::where('template_id', $template->id)->first();

        if ($templateExists) {
               
                return redirect()->back()->with([
                'showModal' => true,
                'modalTitle' => 'Template ini Sudah berisi data',
                'modalMessage' => 'Tekan OK untuk Membuat Duplikasi Template',
                'id' => $template->id,
            ]);
        } else {
            return redirect()->action([TemplateController::class, 'edit'], ['template' => $template]);
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

    public function copyTemplate(Template $template)
    {
        $kategori = Kategori::all();
        
        return view('dashboard.template.copyTemplate',[
            'title' => 'Salin Template',
            'kategori' => $kategori,
            'template' => $template
        ]);
    }
        
}



