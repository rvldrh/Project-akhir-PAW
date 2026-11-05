<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Barang extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'barang';
    protected $primaryKey = 'id_barang';

    protected $fillable = [
        'id_pengguna', 'nama_barang', 'kategori', 'deskripsi_umum',
        'tanggal_ditemukan', 'ciri_khusus', 'merek', 'warna',
        'nomor_seri', 'lokasi_penyimpanan', 'status_barang',
    ];

    protected $casts = [
        'tanggal_ditemukan' => 'date',
    ];

    public function pencatat(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    public function pengajuanKlaim(): HasMany
    {
        return $this->hasMany(PengajuanKlaim::class, 'id_barang', 'id_barang');
    }

    public function buktiPenyerahan(): HasOne
    {
        return $this->hasOne(BuktiPenyerahan::class, 'id_barang', 'id_barang');
    }
}
