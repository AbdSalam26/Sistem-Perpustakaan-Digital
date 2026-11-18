<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('home'))->name('home');

// Setelah login, arahkan sesuai role
Route::get('/dashboard', function () {
    $u = auth()->user();
    if ($u->hasRole('admin'))
        return redirect()->route('admin.dashboard');
    if ($u->hasRole('petugas'))
        return redirect()->route('petugas.dashboard');
    return redirect()->route('buku.index');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->middleware('permission:akses_dashboard_admin')->name('admin.dashboard');
    Route::get('/petugas/dashboard', [DashboardController::class, 'petugas'])
        ->middleware('permission:akses_dashboard_petugas')->name('petugas.dashboard');

    // Buku
    Route::get('/buku', [BukuController::class, 'index'])
        ->middleware('permission:lihat_daftar_buku')->name('buku.index');

    // Soal 3: Gate kelola-buku (create harus SEBELUM /buku/{id})
    Route::get('/buku/create', [BukuController::class, 'create'])
        ->middleware('can:kelola-buku')->name('buku.create');
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])
        ->middleware('can:kelola-buku')->name('buku.destroy');          // Soal 2c: A3 ditambal

    Route::get('/buku/{id}', [BukuController::class, 'show'])
        ->middleware('permission:lihat_daftar_buku')->name('buku.show');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware('permission:lihat_profil_sendiri')->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware('permission:ubah_profil_sendiri')->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->middleware('permission:ubah_profil_sendiri')->name('profile.destroy');

    // Peminjaman milik sendiri
    Route::post('/peminjaman/ajukan/{buku}', [PeminjamanController::class, 'ajukan'])
        ->middleware('permission:mengajukan_peminjaman_buku')->name('peminjaman.ajukan');
    Route::get('/peminjaman/saya', [PeminjamanController::class, 'saya'])
        ->middleware('permission:melihat_riwayat_peminjaman_sendiri')->name('peminjaman.saya');
    Route::get('/riwayat/{user}', [PeminjamanController::class, 'riwayat'])
        ->middleware('permission:melihat_riwayat_peminjaman_sendiri')->name('peminjaman.riwayat');

    // Operasional: admin dan petugas
    Route::get('/kelola/peminjaman', [PeminjamanController::class, 'daftar'])
        ->middleware('permission:kelola_peminjaman')->name('kelola.peminjaman');
    Route::get('/kelola/pengembalian', [PeminjamanController::class, 'pengembalian'])
        ->middleware('permission:kelola_pengembalian')->name('kelola.pengembalian');
    Route::patch('/kelola/peminjaman/{peminjaman}/setujui', [PeminjamanController::class, 'setujui'])
        ->middleware('permission:memproses_persetujuan_peminjaman')->name('kelola.setujui');
    Route::patch('/kelola/peminjaman/{peminjaman}/kembali', [PeminjamanController::class, 'kembali'])
        ->middleware('permission:mencatat_pengembalian_buku')->name('kelola.kembali');
    Route::get('/laporan', [LaporanController::class, 'index'])
        ->middleware('permission:lihat_laporan_perpustakaan')->name('laporan.index');

    // Khusus admin
    Route::get('/admin/users', [UserController::class, 'index'])
        ->middleware('permission:kelola_data_pengguna')->name('admin.users');
    Route::patch('/admin/users/{user}/role', [UserController::class, 'updateRole'])
        ->middleware('permission:kelola_role_pengguna')->name('admin.users.role');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])
        ->middleware('permission:kelola_data_pengguna')->name('admin.users.destroy');

    // Audit keamanan
    Route::get('/daftar-buku', [BukuController::class, 'daftar'])->name('buku.daftar');             // A1 (ditambal di view)
    Route::get('/buku-cari', [BukuController::class, 'cari'])->name('buku.cari');                   // A2 (ditambal di controller)
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show'); // A4 (ditutup Policy di Soal 4)
});

require __DIR__ . '/auth.php';