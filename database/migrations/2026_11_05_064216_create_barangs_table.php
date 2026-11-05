<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->uuid('id_barang')->primary();

            // Satpam pencatat (FK ke pengguna)
            $table->foreignUuid('id_pengguna')
                ->constrained('pengguna', 'id_pengguna')
                ->restrictOnDelete();

            // Data publik
            $table->string('nama_barang', 100);
            $table->string('kategori', 50);
            $table->text('deskripsi_umum')->nullable();
            $table->date('tanggal_ditemukan');

            // Data internal
            $table->text('ciri_khusus');
            $table->string('merek', 50)->nullable();
            $table->string('warna', 30)->nullable();
            $table->string('nomor_seri', 100)->nullable();
            $table->string('lokasi_penyimpanan', 150);

            // Status awal "Ditemukan" (LNF-BR-01)
            $table->enum('status_barang', ['Ditemukan', 'Menunggu Klaim', 'Diklaim', 'Selesai'])
                ->default('Ditemukan');

            // created_at = waktu_dibuat, updated_at = waktu_diperbarui
            $table->timestamps();

            // Indeks kolom pencarian (LNF-NF-04)
            $table->index('nama_barang');
            $table->index('kategori');
            $table->index('tanggal_ditemukan');
            $table->index('status_barang');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
