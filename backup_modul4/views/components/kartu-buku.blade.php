@props(['judul', 'penulis', 'tahun', 'url'])

<div class="card">
   @isset($kategori)
      <span class="badge">{{ $kategori }}</span>
   @endisset

   <h3>{{ $judul }}</h3>
   <p class="meta">Penulis: {{ $penulis }}</p>
   <p class="meta">Tahun terbit: {{ $tahun }}</p>

   {{ $slot }}

   <a href="{{ $url }}" class="btn">Lihat Detail</a>
</div>