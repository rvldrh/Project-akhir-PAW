<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


# Proyek Akhir - Pengembangan Aplikasi Web

Repositori ini berisi kode sumber proyek akhir berbasis framework Laravel untuk mata kuliah **Pengembangan Aplikasi Web**. Aplikasi ini dibangun menggunakan struktur arsitektur MVC (Model-View-Controller) modern untuk menghasilkan platform web yang scalable dan efisien.

## 👥 Anggota Kelompok

| No. | Nama Anggota | NIM |
| :---: | :--- | :--- |
| 1 | Raden Muhammad Rizki Iskandar | 2551507071110035 |
| 2 | Rivaldo Rizky Habibie | 2551507071110046 |
| 3 | Dandika Martha Christiyo | 2551507001110032 |
| 4 | Raihan Lazuardi Ahmad | 2551507001110034 |

---

## 🚀 Fitur Utama Aplikasi


---

## 🛠️ Panduan Instalasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di perangkat lokal Anda:

### 1. Prasyarat Sistem
Pastikan perangkat Anda sudah terinstal perangkat lunak berikut:
- **PHP** (Sesuai dengan kebutuhan versi Laravel proyek ini)
- **Composer** (Dependency manager untuk PHP)
- **MySQL / MariaDB** (Sebagai server basis data)

### 2. Kloning Repositori
Buka terminal dan jalankan perintah berikut:
```bash
git clone https://github.com
cd nama-repositori
```

### 3. Instalasi Dependency
Instal semua package library PHP yang dibutuhkan oleh framework melalui Composer:
```bash
composer install
```

### 4. Konfigurasi Lingkungan (.env)
Salin file konfigurasi bawaan dan sesuaikan pengaturan database Anda:
```bash
cp .env.example .env
```


### 5. Buat Application Key
Generate kunci keamanan unik untuk aplikasi Anda:
```bash
php artisan key:generate
```

### 6. Migrasi Database & Seeding
Buat seluruh tabel basis data beserta data sampel bawaannya secara otomatis:
```bash
php artisan migrate --seed
```

### 7. Jalankan Server Lokal
Nyalakan server pengembangan lokal Laravel:
```bash
php artisan serve
```
Buka browser Anda dan akses alamat **`http://127.0.0.1:8000`** untuk melihat aplikasi berjalan.

---

## 📂 Struktur Utama Direktori

- `app/Http/Controllers/` — Berisi logika penanganan request dan alur bisnis aplikasi.
- `app/Models/` — Representasi struktur data tabel dan relasi antar-entitas database.
- `database/migrations/` — Skrip pembuatan dan modifikasi skema tabel database.
- `resources/views/` — File tampilan antarmuka pengguna (menggunakan Blade templating engine).
- `routes/web.php` — Berisi definisi rute URL utama untuk antarmuka web aplikasi.

---

## ⚖️ Lisensi

Proyek akhir ini bersifat open-source dan berada di bawah naungan [Lisensi MIT](https://opensource.org).
