<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log_audits', function (Blueprint $table) {
            // Identifier menggunakan Primary Key UUID (Char 36)
            $table->uuid('id_log')->primary();

            // Foreign key mengarah ke id_pengguna pada tabel penggunas (atau users)
            $table->uuid('id_pengguna');
            $table->foreign('id_pengguna')
                  ->references('id_pengguna')
                  ->on('pengguna')
                  ->onDelete('cascade');

            // Timestamp waktu aktivitas recorded
            $table->timestamp('waktu');

            // Jenis aktivitas yang dilakukan pengguna (misal: UPDATE_STATUS, LOGIN, dll)
            $table->string('jenis_aktivitas', 50);

            // Jenis entitas sesuai enum/check constraint di laporan
            // Ditambahkan PENCATATAN_BARANG sesuai tindak lanjut temuan kejanggalan dokumen
            $table->enum('jenis_entitas', [
                'PENCATATAN_BARANG',
                'PENGAJUAN_KLAIM',
                'VERIFIKASI_KLAIM',
                'PERUBAHAN_STATUS_BARANG',
                'PENYERAHAN_BARANG'
            ]);

            // ID entitas yang mengalami perubahan (misal: id_barang, id_klaim)
            $table->string('id_entitas', 36);

            // Perubahan nilai data sebelum dan sesudah aktivitas (nullable)
            $table->text('nilai_sebelum')->nullable();
            $table->text('nilai_sesudah')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_audits');
    }
};