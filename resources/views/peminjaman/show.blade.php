@extends('layouts.perpus')
@section('title', 'Detail Peminjaman')
@section('content')
    <h2>Detail Peminjaman #{{ $peminjaman->id }}</h2>
    <p>Anggota: {{ $peminjaman->anggota->nama ?? '-' }}</p>
    <p>Buku: {{ $peminjaman->buku->judul ?? '-' }}</p>
    <p>Status: {{ $peminjaman->status }}</p>
@endsection