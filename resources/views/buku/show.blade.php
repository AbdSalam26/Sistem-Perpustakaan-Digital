
@extends('layouts.perpus')

@section('title', 'Detail Buku')

@section('content')
    <h2>Detail Buku #{{ $buku->id }}</h2>

    <p><strong>Judul:</strong> {{ $buku->judul }}</p>
    <p><strong>Penulis:</strong> {{ $buku->penulis ?? '-' }}</p>
    <p><strong>Penerbit:</strong> {{ $buku->penerbit ?? '-' }}</p>
    <p><strong>Kategori:</strong> {{ $buku->kategori->nama ?? '-' }}</p>

    <a href="{{ route('buku.index') }}">Kembali</a>
@endsection
