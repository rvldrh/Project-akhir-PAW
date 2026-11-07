<?php

namespace App\Http\Controllers\Satpam;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
            ->latest('tanggal_ditemukan')
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
        $search = trim((string) $request->input('search'));
        $kategori = $request->input('kategori');
        $statusBarang = $request->input('status_barang');

        $query = Barang::with('pencatat');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('deskripsi_umum', 'like', "%{$search}%")
                  ->orWhere('lokasi_penyimpanan', 'like', "%{$search}%");
            });
        }

        if (!empty($kategori)) {
            $query->where('kategori', $kategori);
        }

        if (!empty($statusBarang)) {
            $query->where('status_barang', $statusBarang);
        }

        $barangList = $query->latest('tanggal_ditemukan')
            ->latest('created_at')
            ->paginate(15)
            ->withQueryString();

        $kategoriList = Barang::distinct()->orderBy('kategori')->pluck('kategori');
        $statusList = ['Ditemukan', 'Menunggu Klaim', 'Diklaim', 'Selesai'];

        $filters = [
            'search' => $search,
            'kategori' => $kategori,
            'status_barang' => $statusBarang,
        ];

        return view('satpam.barang.index', compact('barangList', 'kategoriList', 'statusList', 'filters'));
    }

    public function create(): View
    {
        return view('satpam.barang.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_barang'        => ['required', 'string', 'max:100'],
            'kategori'           => ['required', 'string', 'max:50'],
            'deskripsi_umum'     => ['nullable', 'string'],
            'tanggal_ditemukan'  => ['required', 'date', 'before_or_equal:today'],
            'ciri_khusus'        => ['required', 'string'],
            'merek'              => ['nullable', 'string', 'max:50'],
            'warna'              => ['nullable', 'string', 'max:30'],
            'nomor_seri'         => ['nullable', 'string', 'max:100'],
            'lokasi_penyimpanan' => ['required', 'string', 'max:150'],
        ]);

        $idPengguna = $request->user()->id_pengguna;

        DB::transaction(function () use ($validated, $idPengguna) {
            $barang = Barang::create([
                'id_pengguna'        => $idPengguna,
                'nama_barang'        => $validated['nama_barang'],
                'kategori'           => $validated['kategori'],
                'deskripsi_umum'     => $validated['deskripsi_umum'] ?? null,
                'tanggal_ditemukan'  => $validated['tanggal_ditemukan'],
                'ciri_khusus'        => $validated['ciri_khusus'],
                'merek'              => $validated['merek'] ?? null,
                'warna'              => $validated['warna'] ?? null,
                'nomor_seri'         => $validated['nomor_seri'] ?? null,
                'lokasi_penyimpanan' => $validated['lokasi_penyimpanan'],
                'status_barang'      => 'Ditemukan',
            ]);

            DB::table('log_audits')->insert([
                'id_log'          => (string) Str::uuid(),
                'id_pengguna'     => $idPengguna,
                'waktu'           => now(),
                'jenis_aktivitas' => 'CREATE',
                'jenis_entitas'   => 'PENCATATAN_BARANG',
                'id_entitas'      => $barang->id_barang,
                'nilai_sebelum'   => null,
                'nilai_sesudah'   => json_encode([
                    'nama_barang'        => $barang->nama_barang,
                    'kategori'           => $barang->kategori,
                    'status_barang'      => $barang->status_barang,
                    'lokasi_penyimpanan' => $barang->lokasi_penyimpanan,
                ], JSON_UNESCAPED_UNICODE),
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        });

        return redirect()
            ->route('satpam.dashboard')
            ->with('success', 'Barang temuan berhasil dicatat.');
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
