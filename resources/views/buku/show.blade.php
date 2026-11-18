@extends('layouts.perpus')

@section('title', 'Detail Peminjaman')

@section('content')
   <h2>Detail Peminjaman #{{ $peminjaman->id }}</h2>
   <p><strong>Anggota:</strong> {{ $peminjaman->anggota->nama ?? '-' }}</p>
   <p><strong>Buku:</strong> {{ $peminjaman->buku->judul ?? '-' }}</p>
   <p><strong>Tanggal pinjam:</strong> {{ $peminjaman->tanggal_pinjam }}</p>
   <p><strong>Status:</strong> {{ $peminjaman->status }}</p>
@endsection