<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    // Halaman daftar buku (Modul 4: data dimuat lewat Fetch API di view)
    public function index()
    {
        return view('buku.index');
    }

    // Detail buku (Modul 1 sampai 5)
    public function show($id)
    {
        $buku = Buku::with('kategori')->find($id);

        return view('buku.show', compact('buku'));
    }

    // A1: daftar buku server-side (view sudah memakai {{ }} setelah Soal 2a)
    public function daftar()
    {
        $bukus = Buku::all();

        return view('buku.daftar', compact('bukus'));
    }

    // A2: AMAN (Soal 2b), query memakai binding
    public function cari(Request $request)
    {
        $judul = $request->query('judul');

        $hasil = DB::select(
            'SELECT id, judul, penulis FROM bukus WHERE judul = ?',
            [$judul]
        );

        return response()->json($hasil);
    }

    // Soal 3: form tambah buku (dibatasi can:kelola-buku di route)
    public function create()
    {
        return view('buku.create');
    }

    // A3: AMAN (Soal 2c), dipanggil lewat route DELETE + CSRF
    public function destroy(Buku $buku)
    {
        // Buku yang punya riwayat peminjaman tidak dihapus (foreign key)
        if (!$buku->peminjamans()->exists()) {
            $buku->delete();
        }

        return redirect()->route('buku.daftar');
    }
}