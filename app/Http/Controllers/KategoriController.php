<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $kategori = Kategori::all();
        return view('dashboard.kategori.index',[
            'title' => 'Kategori',
            'user' => $user->name,
            'kategori' => $kategori,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
          return view('dashboard.kategori.create');
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

        DB::table('kategoris')->insert($validated);
        return redirect('/dashboard/kategori')->with('status', 'Kategori Surat Berhasil Dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        return view('dashboard.kategori.edit',[
            'title' => 'edit',
            'kategori' => $kategori
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $user = Auth::user();
        $validated = $request->validate([
        'nama' => 'required|max:100',
        'deskripsi' => 'required',
    ]);

        $validated['user_id'] = $user->id;

        $validasinama = Kategori::where('id', '!=', $kategori->id)//yang id-nya tidak sama dengan $id
                                ->where('nama', $request->nama)
                                ->first();
        if ($validasinama) {
            return back()->with('error', 'Slug sudah ada, coba yang lain');
        } else {
            DB::table('kategoris')->where('id', $kategori->id)->update($validated);
            return redirect('/dashboard/kategori')->with('status', 'Kategori Surat Berhasil Diedit'); 
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        DB::table('kategoris')->where('id', $kategori->id)->delete();
        return redirect('/dashboard/kategori')->with('status', 'Kategori Surat Berhasil Dihapus');
    }
}
