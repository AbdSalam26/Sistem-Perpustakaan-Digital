<!DOCTYPE html>
<html lang="id">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>@yield('title', 'Perpustakaan') | Perpustakaan Digital</title>
   @vite('resources/css/perpus.css')
</head>

<body>
   <header class="header">
      <h1>📚 Perpustakaan Digital</h1>
      <p>Temukan buku favoritmu di sini</p>
   </header>

<nav class="navbar">
   <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>

   @guest
      <a href="{{ route('login') }}">Login</a>
      <a href="{{ route('register') }}">Register</a>
   @endguest

   @auth
      @can('lihat_daftar_buku')
         <a href="{{ route('buku.index') }}" class="{{ request()->routeIs('buku.*') ? 'active' : '' }}">Daftar Buku</a>
      @endcan
      @can('akses_dashboard_admin')
         <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
      @endcan
      @can('akses_dashboard_petugas')
         <a href="{{ route('petugas.dashboard') }}">Dashboard Petugas</a>
      @endcan
      @can('kelola_data_pengguna')
         <a href="{{ route('admin.users') }}">Pengguna</a>
      @endcan
      @can('kelola_peminjaman')
         <a href="{{ route('kelola.peminjaman') }}">Peminjaman</a>
      @endcan
      @can('kelola_pengembalian')
         <a href="{{ route('kelola.pengembalian') }}">Pengembalian</a>
      @endcan
      @can('lihat_laporan_perpustakaan')
         <a href="{{ route('laporan.index') }}">Laporan</a>
      @endcan
      @can('melihat_riwayat_peminjaman_sendiri')
         <a href="{{ route('peminjaman.saya') }}">Riwayat Saya</a>
      @endcan
      @can('lihat_profil_sendiri')
         <a href="{{ route('profile.edit') }}">Profil ({{ auth()->user()->name }})</a>
      @endcan
      <form method="POST" action="{{ route('logout') }}">
         @csrf
         <button type="submit" class="linkbtn">Logout</button>
      </form>
   @endauth
</nav>

   <main class="content">
      @if (session('sukses'))
         <div class="flash">{{ session('sukses') }}</div>
      @endif
      @yield('content')
   </main>

   <footer class="footer">
      <p>&copy; {{ date('Y') }} Perpustakaan Digital. PBWL Modul 2.</p>
   </footer>
</body>

</html>