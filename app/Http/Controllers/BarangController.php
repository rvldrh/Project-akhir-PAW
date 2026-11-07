<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BarangController extends Controller
{
    private const PUBLIC_COLUMNS = [
        'id_barang',
        'nama_barang',
        'kategori',
        'deskripsi_umum',
        'tanggal_ditemukan',
        'status_barang',
    ];

    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));
        $kategori = $request->input('kategori');
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
        $sort = $request->input('sort', 'terbaru');

        $query = Barang::query()
            ->select(self::PUBLIC_COLUMNS)
            ->whereIn('status_barang', ['Ditemukan', 'Menunggu Klaim']);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('deskripsi_umum', 'like', "%{$search}%");
            });
        }

        if (!empty($kategori)) {
            $query->where('kategori', $kategori);
        }

        if (!empty($tanggalMulai)) {
            $query->whereDate('tanggal_ditemukan', '>=', $tanggalMulai);
        }

        if (!empty($tanggalSelesai)) {
            $query->whereDate('tanggal_ditemukan', '<=', $tanggalSelesai);
        }

        match ($sort) {
            'terlama' => $query->oldest('tanggal_ditemukan'),
            'nama_asc' => $query->orderBy('nama_barang', 'asc'),
            'nama_desc' => $query->orderBy('nama_barang', 'desc'),
            default => $query->latest('tanggal_ditemukan')->latest('created_at'),
        };

        $barangList = $query->paginate(12)->withQueryString();

        $kategoriList = Barang::query()
            ->whereIn('status_barang', ['Ditemukan', 'Menunggu Klaim'])
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        $filters = [
            'search' => $search,
            'kategori' => $kategori,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'sort' => $sort,
        ];

        return view('mahasiswa.dashboard', compact('barangList', 'kategoriList', 'filters'));
    }

    public function show(string $id): View
    {
        $barang = Barang::query()
            ->select(self::PUBLIC_COLUMNS)
            ->findOrFail($id);

        return view('mahasiswa.barang.show', compact('barang'));
    }
}
