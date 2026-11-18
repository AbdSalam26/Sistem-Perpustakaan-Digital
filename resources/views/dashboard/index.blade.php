@extends('layouts.perpus')
@section('title', $judul)
@section('content')
   <h2>{{ $judul }}</h2>
   <p>Halo, {{ auth()->user()->name }}.</p>
   <div class="menu-grid" style="margin-top:16px">
      @can('kelola_data_buku')<a class="btn" href="{{ route('buku.index') }}">Kelola Buku</a>@endcan
      @can('kelola_data_pengguna')<a class="btn" href="{{ route('admin.users') }}">Kelola Pengguna dan Role</a>@endcan
      @can('kelola_peminjaman')<a class="btn" href="{{ route('kelola.peminjaman') }}">Kelola Peminjaman</a>@endcan
      @can('kelola_pengembalian')<a class="btn" href="{{ route('kelola.pengembalian') }}">Kelola Pengembalian</a>@endcan
      @can('lihat_laporan_perpustakaan')<a class="btn" href="{{ route('laporan.index') }}">Laporan</a>@endcan
   </div>
@endsection