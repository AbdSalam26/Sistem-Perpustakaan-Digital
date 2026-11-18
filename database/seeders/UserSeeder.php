<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $akun = [
            ['Admin Perpustakaan', 'admin@perpus.test', 'admin'],
            ['Petugas Perpustakaan', 'petugas@perpus.test', 'petugas'],
            ['Siswa Satu', 'siswa@perpus.test', 'siswa'],
            ['Siswa Dua', 'siswa2@perpus.test', 'siswa'],
        ];

        foreach ($akun as [$nama, $email, $role]) {
            $u = User::updateOrCreate(['email' => $email], [
                'name' => $nama,
                'password' => $email === 'admin@perpus.test'
                    ? 'Ganti!250441100122#'
                    : 'password',
            ]);

            $u->syncRoles([$role]);
        }

        // Riwayat peminjaman contoh untuk tiap siswa
        foreach (['siswa@perpus.test', 'siswa2@perpus.test'] as $email) {
            $u = User::where('email', $email)->first();

            Peminjaman::create([
                'anggota_id' => $u->anggotaSaya()->id,
                'buku_id' => Buku::inRandomOrder()->value('id'),
                'tanggal_pinjam' => now()->toDateString(),
                'status' => 'dipinjam',
            ]);
        }
    }
}
