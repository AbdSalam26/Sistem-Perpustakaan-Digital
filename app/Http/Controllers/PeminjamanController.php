<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;

class PeminjamanController extends Controller
{
    public function ajukan(Buku $buku)
    {
        Peminjaman::create([
            'anggota_id' => auth()->user()->anggotaSaya()->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => now()->toDateString(),
            'status' => 'diajukan',
        ]);

        return redirect()->route('peminjaman.saya')->with('sukses', 'Pengajuan peminjaman dikirim.');
    }

    // Status dan riwayat milik sendiri (selalu dari identitas user yang login)
    public function saya()
    {
        $data = Peminjaman::with('buku')
            ->where('anggota_id', auth()->user()->anggotaSaya()->id)
            ->latest()->get();

        return view('peminjaman.saya', compact('data'));
    }

    // Akses riwayat user lain ditolak, bukan hanya dicek lewat permission
    public function riwayat(User $user)
    {
        abort_unless($user->id === auth()->id(), 403, 'Anda tidak boleh melihat riwayat pengguna lain.');

        return $this->saya();
    }
    // A4: RENTAN IDOR
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])->findOrFail($id);
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function daftar()
    {
        return view('kelola.peminjaman', [
            'judul' => 'Kelola Peminjaman',
            'aksi' => 'setujui',
            'data' => Peminjaman::with(['anggota', 'buku'])->latest()->get(),
        ]);
    }

    public function pengembalian()
    {
        return view('kelola.peminjaman', [
            'judul' => 'Kelola Pengembalian',
            'aksi' => 'kembali',
            'data' => Peminjaman::with(['anggota', 'buku'])->where('status', 'dipinjam')->latest()->get(),
        ]);
    }

    public function setujui(Peminjaman $peminjaman)
    {
        $peminjaman->update(['status' => 'dipinjam', 'tanggal_pinjam' => now()->toDateString()]);

        return back()->with('sukses', 'Peminjaman disetujui.');
    }

    public function kembali(Peminjaman $peminjaman)
    {
        $peminjaman->update(['status' => 'dikembalikan', 'tanggal_kembali' => now()->toDateString()]);

        return back()->with('sukses', 'Pengembalian dicatat.');
    }
}