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
        Schema::create('pengguna', function (Blueprint $table) {
            // Identifier utama berupa Primary Key UUID (CHAR 36)
            $table->uuid('id_pengguna')->primary();

            // Identitas Akun (NIM/NIP) yang unik
            $table->string('identitas_akun', 30)->unique();

            // Nama lengkap pengguna
            $table->string('nama', 100);

            // Kredensial (Password hash)
            $table->string('kredensial', 255);

            // Peran pengguna: Satpam atau Mahasiswa
            $table->enum('peran', ['satpam', 'mahasiswa']);

            // Status akun: Aktif atau Nonaktif (default: Aktif)
            $table->enum('status_akun', ['Aktif', 'Nonaktif'])->default('Aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};