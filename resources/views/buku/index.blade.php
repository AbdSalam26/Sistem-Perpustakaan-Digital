@extends('layouts.perpus')

@section('title', 'Daftar Buku')

@section('content')
   <style>
      .form-buku {
         display: flex;
         flex-wrap: wrap;
         gap: 8px;
         margin-bottom: 20px;
      }

      .form-buku input,
      .form-buku select {
         padding: 9px 12px;
         border-radius: 8px;
         border: 1px solid #888;
         min-width: 150px;
         flex: 1;
      }

      .tabel-buku {
         width: 100%;
         border-collapse: collapse;
      }

      .tabel-buku th,
      .tabel-buku td {
         padding: 10px 12px;
         text-align: left;
         border-bottom: 1px solid rgba(128, 128, 128, .3);
      }

      .pesan {
         padding: 10px 14px;
         border-radius: 8px;
         margin-bottom: 14px;
      }

      .pesan.ok {
         background: #d1fae5;
         color: #065f46;
      }

      .pesan.gagal {
         background: #fee2e2;
         color: #991b1b;
      }

      .btn-kecil {
         padding: 5px 12px;
         margin: 0 2px;
      }

      .paging {
         margin-top: 16px;
         display: flex;
         gap: 10px;
         align-items: center;
      }
   </style>

   <h2>Daftar Buku</h2>

   <div id="pesan" hidden></div>

   <form id="form-buku" class="form-buku" novalidate @cannot('kelola_data_buku') hidden @endcannot>
      <input type="hidden" id="buku-id">
      <select id="kategori_id">
         <option value="">-- Kategori --</option>
      </select>
      <input type="text" id="judul" placeholder="Judul">
      <input type="text" id="penulis" placeholder="Penulis">
      <input type="number" id="tahun_terbit" placeholder="Tahun terbit">
      <button type="submit" id="btn-simpan" class="btn">Tambah</button>
      <button type="button" id="btn-batal" class="btn" hidden>Batal</button>
   </form>

   <table class="tabel-buku">
      <thead>
         <tr>
            <th>No</th>
            <th>Kategori</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Tahun Terbit</th>
            <th>Aksi</th>
         </tr>
      </thead>
      <tbody id="isi-tabel">
         <tr>
            <td colspan="6">Memuat data...</td>
         </tr>
      </tbody>
   </table>

   <div class="paging">
      <button type="button" id="btn-prev" class="btn btn-kecil">&larr; Sebelumnya</button>
      <span id="info-halaman"></span>
      <button type="button" id="btn-next" class="btn btn-kecil">Berikutnya &rarr;</button>
   </div>

   <script data-kelola="{{ auth()->user()->can('kelola_data_buku') ? '1' : '0' }}">
      const KELOLA = document.currentScript.dataset.kelola === '1';
      const API = '/api/buku';
      const HEADERS = {
         'Accept': 'application/json',
         'Content-Type': 'application/json',
         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      };
      const el = (id) => document.getElementById(id);
      const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (c) =>
         ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

      let daftar = [];
      let halaman = 1;
      let terakhir = 1;

      function tampilPesan(teks, tipe = 'ok') {
         const p = el('pesan');
         p.className = 'pesan ' + tipe;
         p.innerHTML = teks;
         p.hidden = false;
      }

      function tampilError(e) {
         if (e instanceof TypeError) {
            return tampilPesan('API tidak dapat diakses. Pastikan server berjalan.', 'gagal');
         }
         let teks = esc(e.message);
         if (e.errors) {
            teks += '<br>' + Object.values(e.errors).flat().map(esc).join('<br>');
         }
         tampilPesan(teks, 'gagal');
      }

      // Semua request lewat sini: cek response.ok, lempar error jika gagal
      async function kirim(url, opsi = {}) {
         const res = await fetch(url, { headers: HEADERS, ...opsi });
         const body = await res.json().catch(() => ({}));
         if (!res.ok) {
            const err = new Error(body.message || 'Permintaan gagal (status ' + res.status + ')');
            err.errors = body.errors;
            throw err;
         }
         return body;
      }

      async function muatKategori() {
         try {
            const body = await kirim('/api/rekap/buku-per-kategori');
            el('kategori_id').innerHTML = '<option value="">-- Kategori --</option>' +
               body.data.map((k) => `<option value="${k.id}">${esc(k.nama)}</option>`).join('');
         } catch (e) { tampilError(e); }
      }

      async function muatBuku(page = 1) {
         try {
            const body = await kirim(`${API}?page=${page}`);
            daftar = body.data;
            halaman = body.meta.current_page;
            terakhir = body.meta.last_page;

            el('isi-tabel').innerHTML = daftar.length
               ? daftar.map((b, i) => `
                           <tr>
                               <td>${(body.meta.from ?? 1) + i}</td>
                               <td>${esc(b.kategori)}</td>
                               <td>${esc(b.judul)}</td>
                               <td>${esc(b.penulis)}</td>
                               <td>${esc(b.tahun)}</td>
                               <td>
                                   <a class="btn btn-kecil" href="/buku/${b.id}">Detail</a>
                                   ${KELOLA ? `<button class="btn btn-kecil" onclick="ubah(${b.id})">Ubah</button>
                                               <button class="btn btn-kecil" onclick="hapus(${b.id})">Hapus</button>` : ''}
                               </td>
                           </tr>`).join('')
               : '<tr><td colspan="6">Belum ada data buku.</td></tr>';

            el('info-halaman').textContent = `Halaman ${halaman} dari ${terakhir}`;
            el('btn-prev').disabled = halaman <= 1;
            el('btn-next').disabled = halaman >= terakhir;
         } catch (e) {
            el('isi-tabel').innerHTML = '<tr><td colspan="6">Gagal memuat data.</td></tr>';
            tampilError(e);
         }
      }

      function resetForm() {
         el('form-buku').reset();
         el('buku-id').value = '';
         el('btn-simpan').textContent = 'Tambah';
         el('btn-batal').hidden = true;
      }

      el('form-buku').addEventListener('submit', async (ev) => {
         ev.preventDefault();
         const id = el('buku-id').value;
         const payload = {
            kategori_id: el('kategori_id').value,
            judul: el('judul').value,
            penulis: el('penulis').value,
            tahun_terbit: el('tahun_terbit').value,
         };

         try {
            const body = await kirim(id ? `${API}/${id}` : API, {
               method: id ? 'PUT' : 'POST',
               body: JSON.stringify(payload),
            });
            tampilPesan(body.message || 'Berhasil disimpan.');
            resetForm();
            await muatBuku(id ? halaman : 1);
         } catch (e) { tampilError(e); }
      });

      function ubah(id) {
         const b = daftar.find((x) => x.id === id);
         if (!b) return;
         el('buku-id').value = b.id;
         el('kategori_id').value = b.kategori_id;
         el('judul').value = b.judul;
         el('penulis').value = b.penulis;
         el('tahun_terbit').value = b.tahun;
         el('btn-simpan').textContent = 'Simpan Perubahan';
         el('btn-batal').hidden = false;
         window.scrollTo({ top: 0, behavior: 'smooth' });
      }

      async function hapus(id) {
         if (!confirm('Yakin ingin menghapus buku ini?')) return;
         try {
            const body = await kirim(`${API}/${id}`, { method: 'DELETE' });
            tampilPesan(body.message);
            if (el('buku-id').value == id) resetForm();
            await muatBuku(daftar.length === 1 && halaman > 1 ? halaman - 1 : halaman);
         } catch (e) { tampilError(e); }
      }

      el('btn-batal').addEventListener('click', resetForm);
      el('btn-prev').addEventListener('click', () => muatBuku(halaman - 1));
      el('btn-next').addEventListener('click', () => muatBuku(halaman + 1));

      if (KELOLA) {
         muatKategori();
      }
      muatBuku();
   </script>
@endsection