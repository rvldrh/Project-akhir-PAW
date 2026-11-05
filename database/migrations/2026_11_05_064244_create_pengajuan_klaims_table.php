<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_klaim', function (Blueprint $table) {
            $table->uuid('id_klaim')->primary();

            $table->foreignUuid('id_barang')
                ->constrained('barang', 'id_barang')
                ->restrictOnDelete();

            // Mahasiswa pengaju klaim
            $table->foreignUuid('id_pengguna')
                ->constrained('pengguna', 'id_pengguna')
                ->restrictOnDelete();

            $table->date('tanggal_klaim');
            $table->text('deskripsi_ciri_khusus');

            $table->enum('status_klaim', [
                'Diajukan', 'Menunggu Verifikasi', 'Terbukti', 'Tidak Terbukti', 'Selesai',
            ])->default('Diajukan');

            $table->timestamps();

            $table->index('status_klaim');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_klaim');
    }
};
