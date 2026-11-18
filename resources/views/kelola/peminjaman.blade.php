@extends('layouts.perpus')
@section('title', $judul)
@section('content')
   <h2>{{ $judul }}</h2>
   <table class="tabel">
      <thead>
         <tr>
            <th>Anggota</th>
            <th>Buku</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
         </tr>
      </thead>
      <tbody>
         @forelse ($data as $p)
            <tr>
               <td>{{ $p->anggota->nama ?? '-' }}</td>
               <td>{{ $p->buku->judul ?? '-' }}</td>
               <td>{{ $p->tanggal_pinjam }}</td>
               <td>{{ $p->tanggal_kembali ?? '-' }}</td>
               <td>{{ $p->status }}</td>
               <td>
                  @if ($aksi === 'setujui' && $p->status === 'diajukan')
                     @can('memproses_persetujuan_peminjaman')
                        <form method="POST" action="{{ route('kelola.setujui', $p) }}">@csrf @method('PATCH')
                           <button class="btn btn-kecil">Setujui</button>
                        </form>
                     @endcan
                  @endif
                  @if ($aksi === 'kembali')
                     @can('mencatat_pengembalian_buku')
                        <form method="POST" action="{{ route('kelola.kembali', $p) }}">@csrf @method('PATCH')
                           <button class="btn btn-kecil">Catat Pengembalian</button>
                        </form>
                     @endcan
                  @endif
               </td>
            </tr>
         @empty
            <tr>
               <td colspan="6">Belum ada data.</td>
            </tr>
         @endforelse
      </tbody>
   </table>
@endsection