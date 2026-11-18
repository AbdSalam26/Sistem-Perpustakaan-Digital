<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;

class RekapController extends Controller
{
    public function bukuPerKategori()
    {
        $data = Kategori::withCount('bukus')->get(['id', 'nama']);

        return response()->json(['data' => $data], 200);
    }

    public function peminjamanPerBuku()
    {
        $data = Buku::withCount('peminjamans')
            ->get(['id', 'judul'])
            ->map(fn($b) => [
                'id' => $b->id,
                'judul' => $b->judul,
                'total_peminjaman' => $b->peminjamans_count,
            ]);

        return response()->json(['data' => $data], 200);
    }
}