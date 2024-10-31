<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    /**
     * Create a new controller instance and apply auth middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_buku = Buku::all();
        $jumlah_buku = Buku::count(); 
        $total_harga = Buku::sum('harga'); 

        return view('buku.index', compact('data_buku', 'jumlah_buku', 'total_harga'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('buku.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
        'judul' => 'required|string|max:255',
        'penulis' => 'required|string|max:255',
        'harga' => 'required|numeric',
        'tanggal_terbit' => 'required|date',
        'photo' => 'image|nullable|max:1999',
    ]);

    $buku = new Buku();
    $buku->judul = $request->judul;
    $buku->penulis = $request->penulis;
    $buku->harga = $request->harga;
    $buku->tanggal_terbit = $request->tanggal_terbit;
    $buku->photo = $path ?? null;

    if ($request->hasFile('photo')) {
        $filenameWithExt = $request->file('photo')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('photo')->getClientOriginalExtension();
        $filenameSimpan = $filename . '_' . time() . '.' . $extension;

        $path = $request->file('photo')->storeAs('public/photos', $filenameSimpan);
        $buku->photo = $filenameSimpan;
    }

    $buku->save();

    return redirect('/buku')->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = Buku::find($id); 
        return view('buku.edit', compact('buku')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    $request->validate([
        'judul' => 'required|string|max:255',
        'penulis' => 'required|string|max:255',
        'harga' => 'required|numeric',
        'tanggal_terbit' => 'required|date',
        'photo' => 'image|nullable|max:1999',
    ]);

    $buku = Buku::find($id);

    if ($request->hasFile('photo')) {
        if ($buku->photo) {
            Storage::delete('public/photos/' . $buku->photo);
        }

        $filename = $request->file('photo')->store('public/photos');
        $buku->photo = basename($filename);
    }

    $buku->judul = $request->judul;
    $buku->penulis = $request->penulis;
    $buku->harga = $request->harga;
    $buku->tanggal_terbit = $request->tanggal_terbit;
    $buku->save();

    return redirect()->route('buku.index')->with('success', 'Buku berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Buku::find($id);
        $buku->delete();

        return redirect('/buku');
    }
}
