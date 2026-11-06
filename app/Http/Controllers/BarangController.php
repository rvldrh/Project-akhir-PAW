<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BarangController extends Controller
{
    public function index(Request $request): View
    {
        $barangList = Barang::query()
            ->select([
                'id_barang',
                'nama_barang',
                'kategori',
                'deskripsi_umum',
                'tanggal_ditemukan',
                'status_barang',
            ])
            ->whereIn('status_barang', ['Ditemukan', 'Menunggu Klaim'])
            ->latest('tanggal_ditemukan')
            ->paginate(12)
            ->withQueryString();

        return view('mahasiswa.dashboard', compact('barangList'));
    }

    public function show(string $id): View
    {
        $barang = Barang::query()
            ->select([
                'id_barang',
                'nama_barang',
                'kategori',
                'deskripsi_umum',
                'tanggal_ditemukan',
                'status_barang',
            ])
            ->findOrFail($id);

        return view('mahasiswa.barang.show', compact('barang'));
    }
}
