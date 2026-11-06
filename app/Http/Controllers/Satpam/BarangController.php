<?php

namespace App\Http\Controllers\Satpam;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\LogAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BarangController extends Controller
{
    public function dashboard(): View
    {
        $totalDitemukan = Barang::where('status_barang', 'Ditemukan')->count();
        $totalMenungguKlaim = Barang::where('status_barang', 'Menunggu Klaim')->count();
        $totalDiklaim = Barang::where('status_barang', 'Diklaim')->count();
        $totalSelesai = Barang::where('status_barang', 'Selesai')->count();

        $barangTerbaru = Barang::with('pencatat')
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('satpam.dashboard', compact(
            'totalDitemukan',
            'totalMenungguKlaim',
            'totalDiklaim',
            'totalSelesai',
            'barangTerbaru'
        ));
    }

    public function index(Request $request): View
    {
        $barangList = Barang::with('pencatat')
            ->latest()
            ->paginate(15);

        return view('satpam.barang.index', compact('barangList'));
    }

    public function create(): View
    {
        return view('satpam.barang.create');
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('satpam.dashboard');
    }

    public function show(string $id): View
    {
        $barang = Barang::with(['pencatat', 'pengajuanKlaim'])->findOrFail($id);

        return view('satpam.barang.show', compact('barang'));
    }

    public function edit(string $id): View
    {
        $barang = Barang::findOrFail($id);

        return view('satpam.barang.edit', compact('barang'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        return redirect()->route('satpam.barang.show', $id);
    }

    public function updateStatus(Request $request, string $id): RedirectResponse
    {
        return redirect()->route('satpam.barang.show', $id);
    }
}
