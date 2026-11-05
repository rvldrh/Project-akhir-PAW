<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuktiPenyerahan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'bukti_penyerahan';
    protected $primaryKey = 'id_serah_terima';

    // Tabel ini tidak punya created_at / updated_at (sesuai PDM)
    public $timestamps = false;

    protected $fillable = [
        'id_barang', 'id_klaim', 'id_pengguna', 'tanggal_waktu',
        'identitas_penerima_diperiksa', 'file_bukti_serah_terima',
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime',
        'identitas_penerima_diperiksa' => 'boolean',
    ];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function pengajuanKlaim(): BelongsTo
    {
        return $this->belongsTo(PengajuanKlaim::class, 'id_klaim', 'id_klaim');
    }

    public function satpam(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}