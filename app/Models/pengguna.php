<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{ 
    use HasFactory, HasUuids;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';

    protected $fillable = [
        'identitas_akun',
        'nama',
        'kredensial',
        'peran',
        'status_akun',
    ];

    protected $hidden = [
        'kredensial',
    ];

    protected $casts = [
        // Otomatis di-hash saat disimpan
        'kredensial' => 'hashed',
    ];

    /**
     * Kolom password di tabel ini bernama "kredensial",
     * bukan "password", sehingga harus diberitahukan ke sistem auth.
     */
    public function getAuthPassword(): string
    {
        return $this->kredensial;
    }

    /**
     * Tabel pengguna tidak punya kolom remember_token,
     * jadi fitur "remember me" dinonaktifkan.
     */
    public function getRememberTokenName(): string
    {
        return '';
    }

    // ---------- Helper peran & status ----------

    public function isSatpam(): bool
    {
        return $this->peran === 'satpam';
    }

    public function isMahasiswa(): bool
    {
        return $this->peran === 'mahasiswa';
    }

    public function isAktif(): bool
    {
        return $this->status_akun === 'Aktif';
    }

    // ---------- Relasi ----------

    // Satpam mencatat Barang
    public function barangDicatat(): HasMany
    {
        return $this->hasMany(Barang::class, 'id_pengguna', 'id_pengguna');
    }

    // Mahasiswa mengajukan Pengajuan Klaim
    public function pengajuanKlaim(): HasMany
    {
        return $this->hasMany(PengajuanKlaim::class, 'id_pengguna', 'id_pengguna');
    }

    // Satpam membuat Bukti Penyerahan
    public function buktiPenyerahan(): HasMany
    {
        return $this->hasMany(BuktiPenyerahan::class, 'id_pengguna', 'id_pengguna');
    }
}
