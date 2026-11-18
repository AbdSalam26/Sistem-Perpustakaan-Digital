<!DOCTYPE html>
<html lang="id">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>@yield('title', 'Perpustakaan') | Perpustakaan Digital</title>
   @vite('resources/css/app.css')
</head>

<body>
   <header class="header">
      <h1>📚 Perpustakaan Digital</h1>
      <p>Temukan buku favoritmu di sini</p>
   </header>

   <nav class="navbar">
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
      <a href="{{ route('buku.index') }}" class="{{ request()->routeIs('buku.*') ? 'active' : '' }}">Daftar Buku</a>
   </nav>

   <main class="content">
      @yield('content')
   </main>

   <footer class="footer">
      <p>&copy; {{ date('Y') }} Perpustakaan Digital. PBWL Modul 2.</p>
   </footer>
</body>

</html>