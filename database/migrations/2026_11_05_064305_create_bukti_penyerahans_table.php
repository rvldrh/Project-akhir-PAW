<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukti_penyerahan', function (Blueprint $table) {
            $table->uuid('id_serah_terima')->primary();

            // unique: relasi Barang 0,1 -- Bukti Penyerahan (CDM)
            $table->foreignUuid('id_barang')
                ->unique()
                ->constrained('barang', 'id_barang')
                ->restrictOnDelete();

            // unique: relasi Pengajuan Klaim 0,1 -- Bukti Penyerahan (CDM)
            $table->foreignUuid('id_klaim')
                ->unique()
                ->constrained('pengajuan_klaim', 'id_klaim')
                ->restrictOnDelete();

            // Satpam yang menyerahkan
            $table->foreignUuid('id_pengguna')
                ->constrained('pengguna', 'id_pengguna')
                ->restrictOnDelete();

            $table->timestamp('tanggal_waktu');
            $table->boolean('identitas_penerima_diperiksa')->default(false);
            $table->text('file_bukti_serah_terima'); // path file foto
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukti_penyerahan');
    }
};