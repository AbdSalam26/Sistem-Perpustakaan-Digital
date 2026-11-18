@extends('layouts.perpus')

@section('title', 'Daftar Buku (Blade)')

@section('content')
   <h2>Daftar Buku</h2>

   <table class="tabel">
      <thead>
         <tr>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Aksi</th>
         </tr>
      </thead>
      <tbody>
         @foreach ($bukus as $b)
            <tr>
               {{-- AMAN (Soal 2a): {{ }} melakukan escaping --}}
               <td>{{ $b->judul }}</td>
               <td>{{ $b->penulis }}</td>
               <td>
                  <a class="btn btn-kecil" href="{{ route('buku.show', $b->id) }}">Detail</a>

                  {{-- Soal 2c: hapus lewat DELETE + CSRF; Soal 3: hanya admin/petugas --}}
                  @can('kelola-buku')
                     <form method="POST" action="{{ route('buku.destroy', $b->id) }}" style="display:inline"
                           onsubmit="return confirm('Hapus buku ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-kecil">Hapus</button>
                     </form>
                  @endcan
               </td>
            </tr>
         @endforeach
      </tbody>
   </table>
@endsection