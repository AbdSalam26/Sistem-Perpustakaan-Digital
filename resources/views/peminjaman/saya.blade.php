@extends('layouts.perpus')
@section('title', 'Riwayat Peminjaman Saya')
@section('content')
   <h2>Status dan Riwayat Peminjaman Saya</h2>
   <table class="tabel">
      <thead>
         <tr>
            <th>Buku</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
         </tr>
      </thead>
      <tbody>
         @forelse ($data as $p)
            <tr>
               <td>{{ $p->buku->judul ?? '-' }}</td>
               <td>{{ $p->tanggal_pinjam }}</td>
               <td>{{ $p->tanggal_kembali ?? '-' }}</td>
               <td>{{ $p->status }}</td>
            </tr>
         @empty
            <tr>
               <td colspan="4">Belum ada riwayat peminjaman.</td>
            </tr>
         @endforelse
      </tbody>
   </table>
@endsection