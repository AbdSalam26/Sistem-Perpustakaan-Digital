@extends('layouts.perpus')
@section('title', 'Kelola Pengguna')
@section('content')
   <h2>Kelola Pengguna dan Role</h2>
   <table class="tabel">
      <thead>
         <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
         </tr>
      </thead>
      <tbody>
         @foreach ($users as $u)
            <tr>
               <td>{{ $u->name }}</td>
               <td>{{ $u->email }}</td>
               <td>
                  @can('kelola_role_pengguna')
                     <form method="POST" action="{{ route('admin.users.role', $u) }}" style="display:flex;gap:6px">
                        @csrf @method('PATCH')
                        <select name="role">
                           @foreach ($roles as $r)
                              <option value="{{ $r }}" @selected($u->hasRole($r))>{{ $r }}</option>
                           @endforeach
                        </select>
                        <button class="btn btn-kecil">Simpan</button>
                     </form>
                  @endcan
               </td>
               <td>
                  @if ($u->id !== auth()->id())
                     <form method="POST" action="{{ route('admin.users.destroy', $u) }}"
                        onsubmit="return confirm('Hapus pengguna ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-kecil">Hapus</button>
                     </form>
                  @endif
               </td>
            </tr>
         @endforeach
      </tbody>
   </table>
@endsection