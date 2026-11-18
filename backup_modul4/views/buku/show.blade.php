@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
   @if ($buku)
      <div class="detail">
         <span class="badge">{{ $buku->kategori->nama }}</span>
         <h2>{{ $buku->judul }}</h2>
         <p><strong>ID Buku:</strong> {{ $buku->id }}</p>
         <p><strong>Penulis:</strong> {{ $buku->penulis }}</p>
         <p><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit }}</p>
         <a href="{{ route('buku.index') }}" class="btn">&larr; Kembali ke Daftar</a>
      </div>
   @else
      <div class="detail empty">
         <h2>Buku tidak ditemukan</h2>
         <p>Data buku dengan ID tersebut tidak ada.</p>
         <a href="{{ route('buku.index') }}" class="btn">&larr; Kembali ke Daftar</a>
      </div>
   @endif
@endsection