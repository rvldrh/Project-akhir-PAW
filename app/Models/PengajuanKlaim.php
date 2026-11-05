<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PengajuanKlaim extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pengajuan_klaim';
    protected $primaryKey = 'id_klaim';

    protected $fillable = [
        'id_barang', 'id_pengguna', 'tanggal_klaim',
        'deskripsi_ciri_khusus', 'status_klaim',
    ];

    protected $casts = [
        'tanggal_klaim' => 'date',
    ];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function pengaju(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    public function buktiPenyerahan(): HasOne
    {
        return $this->hasOne(BuktiPenyerahan::class, 'id_klaim', 'id_klaim');
    }
}