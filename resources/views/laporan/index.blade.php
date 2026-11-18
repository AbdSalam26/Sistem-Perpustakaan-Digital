@extends('layouts.perpus')
@section('title', 'Laporan')
@section('content')
   <h2>Laporan Perpustakaan</h2>
   <p>Total buku: <strong>{{ $totalBuku }}</strong> | Total anggota: <strong>{{ $totalAnggota }}</strong></p>

   <h3 style="margin-top:20px">Peminjaman per status</h3>
   <table class="tabel">
      <thead>
         <tr>
            <th>Status</th>
            <th>Jumlah</th>
         </tr>
      </thead>
      <tbody>@foreach ($perStatus as $s => $j)
         <tr>
            <td>{{ $s }}</td>
            <td>{{ $j }}</td>
      </tr>@endforeach
      </tbody>
   </table>

   <h3 style="margin-top:20px">Buku per kategori</h3>
   <table class="tabel">
      <thead>
         <tr>
            <th>Kategori</th>
            <th>Jumlah buku</th>
         </tr>
      </thead>
      <tbody>@foreach ($bukuPerKategori as $k)
         <tr>
            <td>{{ $k->nama }}</td>
            <td>{{ $k->bukus_count }}</td>
      </tr>@endforeach
      </tbody>
   </table>
@endsection