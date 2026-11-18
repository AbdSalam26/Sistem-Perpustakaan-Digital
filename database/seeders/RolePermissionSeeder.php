<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $semua = [
            'akses_dashboard_admin',
            'akses_dashboard_petugas',
            'lihat_daftar_buku',
            'kelola_data_buku',
            'kelola_data_pengguna',
            'kelola_role_pengguna',
            'kelola_peminjaman',
            'kelola_pengembalian',
            'mengajukan_peminjaman_buku',
            'memproses_persetujuan_peminjaman',
            'mencatat_pengembalian_buku',
            'melihat_status_peminjaman_sendiri',
            'melihat_riwayat_peminjaman_sendiri',
            'lihat_laporan_perpustakaan',
            'lihat_profil_sendiri',
            'ubah_profil_sendiri',
        ];

        foreach ($semua as $p) {
            Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
        }

        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions(array_diff($semua, ['akses_dashboard_petugas']));

        $petugas = Role::firstOrCreate(['name' => 'petugas', 'guard_name' => 'web']);
        $petugas->syncPermissions(array_diff($semua, [
            'akses_dashboard_admin',
            'kelola_data_pengguna',
            'kelola_role_pengguna',
        ]));

        $siswa = Role::firstOrCreate(['name' => 'siswa', 'guard_name' => 'web']);
        $siswa->syncPermissions([
            'lihat_daftar_buku',
            'mengajukan_peminjaman_buku',
            'melihat_status_peminjaman_sendiri',
            'melihat_riwayat_peminjaman_sendiri',
            'lihat_profil_sendiri',
            'ubah_profil_sendiri',
        ]);
    }
}