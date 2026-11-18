<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BukuResource;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    private function aturan(bool $sebagian = false): array
    {
        $aturan = [
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'judul' => ['required', 'string', 'min:3', 'max:150'],
            'penulis' => ['required', 'string', 'min:3', 'max:100'],
            'tahun_terbit' => ['required', 'integer', 'between:1900,' . date('Y')],
        ];

        if ($sebagian) {
            $aturan = array_map(fn($r) => array_merge(['sometimes'], $r), $aturan);
        }

        return $aturan;
    }

    private function pesan(): array
    {
        return [
            'kategori_id.required' => 'Kategori wajib diisi.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'judul.required' => 'Judul buku wajib diisi.',
            'judul.string' => 'Judul buku harus berupa teks.',
            'judul.min' => 'Judul buku minimal 3 karakter.',
            'judul.max' => 'Judul buku maksimal 150 karakter.',
            'penulis.required' => 'Penulis wajib diisi.',
            'penulis.string' => 'Penulis harus berupa teks.',
            'penulis.min' => 'Penulis minimal 3 karakter.',
            'penulis.max' => 'Penulis maksimal 100 karakter.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa bilangan bulat.',
            'tahun_terbit.between' => 'Tahun terbit harus antara 1900 sampai ' . date('Y') . '.',
        ];
    }

    private function atribut(): array
    {
        return [
            'kategori_id' => 'kategori',
            'tahun_terbit' => 'tahun terbit',
        ];
    }

    public function index(Request $request)
    {
        $bukus = Buku::with('kategori')
            ->withCount('peminjamans')
            ->when($request->filled('cari'), function ($q) use ($request) {
                $cari = $request->cari;
                $q->where(fn($q) => $q->where('judul', 'like', "%{$cari}%")
                    ->orWhere('penulis', 'like', "%{$cari}%"));
            })
            ->when($request->filled('kategori'), fn($q) => $q->where('kategori_id', $request->kategori))
            ->when($request->filled('tahun'), fn($q) => $q->where('tahun_terbit', $request->tahun))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return BukuResource::collection($bukus);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->aturan(), $this->pesan(), $this->atribut());

        $buku = Buku::create($data);

        return (new BukuResource($buku->load('kategori')))
            ->additional(['message' => 'Buku berhasil ditambahkan'])
            ->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        $buku = Buku::with(['kategori', 'peminjamans'])->find($id);

        if (!$buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        return new BukuResource($buku);
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        $data = $request->validate($this->aturan(true), $this->pesan(), $this->atribut());

        $buku->update($data);

        return (new BukuResource($buku->load('kategori')))
            ->additional(['message' => 'Buku berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        if ($buku->peminjamans()->exists()) {
            return response()->json([
                'message' => 'Buku tidak bisa dihapus karena masih memiliki riwayat peminjaman',
            ], 409);
        }

        $buku->delete();

        return response()->json(['message' => 'Buku berhasil dihapus'], 200);
    }
}