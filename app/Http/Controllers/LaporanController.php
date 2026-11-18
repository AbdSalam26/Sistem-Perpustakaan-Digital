<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index', [
            'totalBuku' => Buku::count(),
            'totalAnggota' => Anggota::count(),
            'perStatus' => Peminjaman::selectRaw('status, count(*) as jumlah')->groupBy('status')->pluck('jumlah', 'status'),
            'bukuPerKategori' => Kategori::withCount('bukus')->get(),
        ]);
    }
}