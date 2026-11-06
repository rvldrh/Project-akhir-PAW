# AGENTS.md

# FILKOM Finders — Project Development Guidelines

Dokumen ini menjadi pedoman utama bagi seluruh developer dan AI coding agent dalam mengembangkan **FILKOM Finders**, yaitu Sistem Informasi Manajemen Barang Hilang dan Temuan (*Lost and Found*) di lingkungan Fakultas Ilmu Komputer Universitas Brawijaya.

Seluruh perubahan kode harus mengikuti arsitektur, aturan bisnis, pembagian tanggung jawab, standar database, dan alur kerja Git yang ditetapkan dalam dokumen ini.

---

## 1. Project Overview

### 1.1 Deskripsi Proyek

FILKOM Finders merupakan aplikasi berbasis web untuk membantu pengelolaan barang hilang dan temuan di lingkungan FILKOM UB.

Sistem ini menyediakan:
- Katalog publik barang temuan.
- Pencarian dan penyaringan barang.
- Pencatatan barang temuan oleh Satpam.
- Pengelolaan informasi publik dan informasi internal barang.
- Pengajuan klaim kepemilikan oleh Mahasiswa.
- Penyimpanan bukti pendukung klaim.
- Verifikasi klaim oleh Satpam.
- Pembaruan status barang dan klaim.
- Pencatatan bukti penyerahan barang.
- Pencatatan riwayat aktivitas penting melalui Log Audit.

Sistem berfungsi sebagai media pencatatan dan pelacakan informasi. Verifikasi kepemilikan dan penyerahan barang tetap dilakukan secara langsung oleh Satpam di Pos Satpam Gedung F.

### 1.2 Technology Stack

Gunakan teknologi berikut sebagai acuan pengembangan:

| Komponen | Teknologi |
|---|---|
| Backend | Laravel 13 |
| Bahasa Backend | PHP 8.4+ |
| Frontend | Blade |
| Styling | Tailwind CSS 4 |
| Database | MySQL |
| Database Hosting | Aiven |
| Asset Bundler | Vite |
| Version Control | Git & GitHub |
| Deployment | Vercel |

Jangan menambahkan framework, library, atau dependensi baru tanpa alasan teknis yang jelas dan mempertimbangkan kebutuhan tim.

### 1.3 Repository dan Deployment

- Repository digunakan sebagai sumber kode utama proyek.
- Database Aiven digunakan bersama oleh developer dan deployment.
- Vercel digunakan untuk deployment aplikasi.
- Branch `main` menjadi sumber deployment production.
- Branch `dev` menjadi integrasi pengembangan tim.

Jangan menganggap lingkungan lokal, database Aiven, dan production sebagai lingkungan yang terpisah sepenuhnya. Perubahan terhadap database Aiven dapat berdampak langsung terhadap developer lain dan aplikasi yang sedang berjalan.

---

## 2. General Development Rules

### 2.1 General Principles

Seluruh developer dan AI coding agent wajib:

1. Memahami struktur proyek sebelum melakukan perubahan.
2. Membaca file yang berkaitan dengan fitur yang akan dikerjakan.
3. Mengikuti pola penulisan kode yang sudah digunakan dalam proyek.
4. Menghindari perubahan terhadap file yang tidak berkaitan dengan tugas.
5. Tidak menghapus atau mengganti implementasi yang sudah ada tanpa alasan yang jelas.
6. Tidak membuat duplikasi fungsi, komponen, atau business logic.
7. Mengutamakan kode yang mudah dibaca, dipelihara, dan dikembangkan.
8. Memastikan perubahan tidak merusak fitur yang sudah berjalan.
9. Tidak mengubah aturan bisnis tanpa persetujuan tim.
10. Tidak mengarang struktur database, nama kolom, route, atau relasi yang belum diverifikasi.

### 2.2 Before Making Changes

Sebelum mengimplementasikan fitur:

1. Periksa branch Git yang sedang digunakan.
2. Pastikan perubahan lokal yang belum di-commit tidak tertimpa.
3. Periksa struktur direktori dan file terkait.
4. Periksa model, migration, controller, route, dan view yang berhubungan.
5. Pastikan perubahan tidak bertentangan dengan pekerjaan developer lain.
6. Jika perubahan membutuhkan modifikasi file milik developer lain, koordinasikan terlebih dahulu.

Jangan melakukan perubahan besar hanya berdasarkan asumsi atau nama file.

### 2.3 Code Quality

- Gunakan penamaan variabel, method, class, dan file yang konsisten.
- Hindari kode yang tidak digunakan.
- Hindari duplikasi business logic.
- Gunakan validasi input pada proses yang menerima data pengguna.
- Gunakan mekanisme authorization untuk membatasi akses.
- Gunakan Eloquent ORM untuk interaksi database pada aplikasi.
- Gunakan database transaction ketika beberapa perubahan data harus berhasil atau gagal secara bersamaan.
- Tangani error secara tepat dan jangan menampilkan informasi sensitif kepada pengguna.
- Jangan menyimpan password dalam bentuk plaintext.
- Jangan menaruh credential atau secret di dalam source code.

---

## 3. Application Architecture and Business Rules

### 3.1 User Roles

Sistem memiliki dua role pengguna yang telah terautentikasi:

| Role | Deskripsi |
|---|---|
| `mahasiswa` | Pengguna yang dapat melihat katalog publik, mencari barang, mengajukan klaim, dan memantau status klaim. |
| `satpam` | Pengelola sistem yang dapat mencatat barang, melihat informasi internal, memverifikasi klaim, memperbarui status barang, dan mencatat penyerahan barang. |

Pengunjung yang belum login hanya dapat mengakses halaman publik yang memang diizinkan.

### 3.2 Role Authorization

Aturan hak akses:

**Pengunjung**
- Dapat melihat katalog publik.
- Dapat mencari dan menyaring barang.
- Tidak dapat melihat informasi internal barang.
- Tidak dapat mengajukan klaim.
- Tidak dapat melakukan perubahan data.

**Mahasiswa**
- Dapat mengakses katalog publik.
- Dapat mengajukan klaim kepemilikan.
- Dapat memberikan informasi atau bukti pendukung klaim.
- Dapat melihat status klaim miliknya.
- Tidak dapat menetapkan hasil verifikasi klaim.
- Tidak dapat mengubah status barang secara langsung.
- Tidak dapat mengakses informasi internal barang.

**Satpam**
- Dapat mencatat barang temuan.
- Dapat melihat informasi publik dan internal barang.
- Dapat mengelola data barang sesuai kewenangannya.
- Dapat memeriksa pengajuan klaim.
- Dapat menetapkan hasil verifikasi klaim.
- Dapat memperbarui status barang sesuai alur bisnis.
- Dapat mencatat proses penyerahan barang.

Jangan hanya menyembunyikan tombol atau menu pada frontend untuk membatasi akses. Seluruh pembatasan hak akses harus diterapkan dan diverifikasi di backend melalui middleware, policy, gate, atau mekanisme authorization yang sesuai.

### 3.3 Barang: Public and Internal Information

Informasi barang harus dibedakan menjadi informasi publik dan informasi internal.

**Informasi publik:**
- `id_barang`
- `nama_barang`
- `kategori`
- `deskripsi_umum`
- `tanggal_ditemukan`
- `status_barang`

**Informasi internal:**
- `ciri_khusus`
- `merek`
- `warna`
- `nomor_seri`
- `lokasi_penyimpanan`
- `id_pengguna` (sesuai relasi dan kebutuhan internal pencatatan)

Ketentuan:

1. Informasi publik dapat ditampilkan kepada pengunjung dan mahasiswa.
2. Informasi internal hanya boleh diakses oleh Satpam yang berwenang.
3. Ciri khusus tidak boleh ditampilkan dalam katalog publik.
4. Informasi internal tidak boleh bocor melalui response API, JSON, HTML, atribut DOM, atau sumber data frontend.
5. Jangan mengirim seluruh data barang ke frontend kemudian hanya menyembunyikan beberapa field menggunakan CSS atau JavaScript.
6. Gunakan query atau resource/transformer yang secara eksplisit membatasi field berdasarkan kebutuhan akses.

Tujuan pemisahan ini adalah mencegah calon pengklaim menggunakan informasi internal untuk menebak ciri barang.

### 3.4 Claim Verification

Alur utama klaim:

1. Mahasiswa melihat barang pada katalog publik.
2. Mahasiswa mengajukan klaim terhadap barang.
3. Mahasiswa memberikan informasi atau bukti pendukung kepemilikan.
4. Satpam memeriksa pengajuan klaim.
5. Satpam melakukan verifikasi secara langsung dengan mencocokkan bukti dan ciri khusus barang.
6. Satpam menetapkan hasil verifikasi.
7. Jika klaim terbukti, proses dilanjutkan menuju penyerahan barang.
8. Setelah barang diserahkan secara fisik, proses dicatat dan diselesaikan dalam sistem.

Ketentuan:
- Mahasiswa tidak dapat memverifikasi klaim miliknya sendiri.
- Sistem tidak boleh menetapkan kepemilikan secara otomatis.
- Status klaim harus diperbarui berdasarkan keputusan Satpam.
- Penyerahan barang tetap dilakukan secara langsung.
- Setiap aktivitas penting harus tercatat dalam Log Audit sesuai cakupannya.

### 3.5 Status Values

Gunakan nilai status berikut secara konsisten.

**Status barang (`status_barang`):**

| Nilai | Keterangan |
|---|---|
| `Ditemukan` | Barang telah dicatat dan belum memasuki proses klaim. |
| `Menunggu Klaim` | Barang sedang berada dalam proses pengajuan atau penanganan klaim. |
| `Diklaim` | Klaim telah terbukti dan barang menunggu penyelesaian penyerahan. |
| `Selesai` | Proses penanganan dan penyerahan barang telah selesai. |

**Status klaim (`status_klaim`):**

| Nilai | Keterangan |
|---|---|
| `Diajukan` | Mahasiswa telah mengirimkan pengajuan klaim. |
| `Menunggu Verifikasi` | Klaim menunggu pemeriksaan Satpam. |
| `Terbukti` | Klaim telah dinyatakan valid oleh Satpam. |
| `Tidak Terbukti` | Klaim tidak berhasil membuktikan kepemilikan. |
| `Selesai` | Proses klaim telah diselesaikan setelah penyerahan barang. |

**Status akun (`status_akun`):**

| Nilai | Keterangan |
|---|---|
| `Aktif` | Akun dapat digunakan. |
| `Nonaktif` | Akun tidak dapat menggunakan sistem sesuai aturan autentikasi. |

Jangan membuat variasi penulisan status seperti `ditemukan`, `DITEMUKAN`, atau `Menunggu_verifikasi`.

Perhatikan bahwa perubahan status harus mengikuti alur bisnis, bukan dilakukan secara bebas dari halaman frontend.

### 3.6 Password and Authentication

- Kolom `pengguna.kredensial` menyimpan password dalam bentuk hash.
- Password wajib di-hash menggunakan mekanisme hashing Laravel.
- Login menggunakan `identitas_akun`.
- Jangan membandingkan password dengan nilai plaintext dari database.
- Jangan mengirim nilai `kredensial` ke frontend.
- Jangan mencatat password atau token autentikasi ke Log Audit.
- Gunakan konfigurasi authentication Laravel yang telah disepakati tim.

---

## 4. Database Management Rules

Bagian ini wajib dipatuhi karena database Aiven digunakan bersama oleh seluruh developer.

### 4.1 Database Structure Management (DDL)

DDL mencakup perubahan struktur database, seperti:

- `CREATE TABLE`
- `ALTER TABLE`
- `DROP TABLE`
- Penambahan atau penghapusan kolom.
- Perubahan tipe data.
- Pembuatan atau penghapusan foreign key.
- Penambahan atau penghapusan constraint.
- Pembuatan atau penghapusan index.

**Seluruh perubahan struktur database wajib dilakukan melalui Laravel Migration.**

Ketentuan:

1. Jangan mengubah struktur database secara manual melalui MySQL Workbench.
2. Jangan menjalankan `CREATE TABLE`, `ALTER TABLE`, atau `DROP TABLE` secara manual pada database Aiven.
3. Setiap perubahan struktur harus memiliki migration yang sesuai.
4. Migration harus diperiksa sebelum dijalankan pada database bersama.
5. Jangan mengubah migration lama yang sudah pernah dijalankan pada database bersama untuk memperbaiki struktur. Buat migration baru.
6. Pastikan migration dapat dijalankan tanpa menghapus data yang sudah ada.
7. Pertimbangkan foreign key, index, nullable, default value, dan constraint sebelum membuat migration.

Contoh:

```bash
php artisan make:migration add_status_to_barang_table
```

Setelah migration dibuat, periksa isi file migration sebelum menjalankannya.

### 4.2 Database Data Management (DML)

DML mencakup operasi terhadap isi data, seperti:

- `SELECT`
- `INSERT`
- `UPDATE`
- `DELETE`

Operasi DML dapat dilakukan melalui MySQL Workbench untuk kebutuhan tertentu.

Aturannya:

**MySQL Workbench diperbolehkan untuk:**
- Memeriksa isi tabel.
- Melakukan `SELECT` untuk pemeriksaan data.
- Menambahkan data sementara untuk pengujian.
- Mengubah atau menghapus data pengujian yang memang telah disepakati.
- Melakukan pengecekan hasil migration.

**Laravel Seeder digunakan untuk:**
- Membuat data awal yang konsisten.
- Membuat data dummy yang dibutuhkan seluruh developer.
- Menyediakan akun atau data pengujian yang dapat dibuat ulang.
- Menyiapkan data referensi yang dibutuhkan aplikasi.

**Laravel Application digunakan untuk:**
- Menjalankan transaksi bisnis.
- Membuat pengajuan klaim.
- Memperbarui status barang.
- Memverifikasi klaim.
- Mencatat penyerahan barang.
- Menjalankan perubahan data yang harus mengikuti validasi, authorization, dan business logic.

Jangan menggunakan MySQL Workbench untuk melewati validasi atau aturan bisnis aplikasi.

### 4.3 Shared Aiven Database

Database Aiven merupakan database bersama.

Karena itu:

1. Jangan menganggap database Aiven sebagai database pribadi.
2. Koordinasikan perubahan struktur database dengan tim sebelum menjalankan migration baru.
3. Pastikan migration tidak menghapus atau merusak data developer lain.
4. Jangan menjalankan migration yang belum diperiksa pada database bersama.
5. Jangan mengubah data pengujian milik developer lain tanpa koordinasi.
6. Jangan menghapus data production atau data bersama hanya untuk mengulang pengujian.
7. Jangan menjalankan perintah migration yang bersifat destruktif tanpa persetujuan tim.

**Perintah yang dilarang dijalankan pada database bersama tanpa persetujuan eksplisit tim:**

```bash
php artisan migrate:fresh
php artisan migrate:refresh
php artisan migrate:rollback
php artisan db:wipe
```

Perintah tersebut dapat menghapus tabel, membatalkan migration, atau menghilangkan data yang digunakan developer lain.

### 4.4 Database Migration Workflow

Sebelum membuat atau menjalankan migration:

1. Periksa migration yang sudah tersedia.
2. Periksa struktur tabel saat ini.
3. Pastikan tidak ada migration serupa yang sedang dikerjakan developer lain.
4. Koordinasikan perubahan dengan developer yang bertanggung jawab atas database.
5. Buat migration baru.
6. Periksa SQL dan efek perubahan yang dihasilkan migration.
7. Jalankan dan uji pada database lokal atau lingkungan pengujian yang sesuai.
8. Setelah disepakati, jalankan migration pada database Aiven.
9. Pastikan hasil migration sesuai dengan struktur yang diharapkan.
10. Commit file migration ke Git agar seluruh developer memiliki versi struktur database yang sama.

Jangan menganggap migration berhasil hanya karena perintah Artisan selesai. Periksa hasil perubahan tabel dan relasinya.

### 4.5 Seeder Rules

Gunakan Seeder untuk menyediakan data yang konsisten.

Contoh:

```bash
php artisan make:seeder PenggunaSeeder
php artisan db:seed --class=PenggunaSeeder
```

Ketentuan:

- Seeder harus dapat dijalankan sesuai kondisi data yang ditargetkan.
- Hindari duplikasi data ketika Seeder dijalankan kembali.
- Jangan memasukkan data rahasia atau password plaintext.
- Jangan memasukkan data pribadi nyata tanpa kebutuhan dan izin.
- Jangan menjalankan Seeder yang menghapus atau menimpa data bersama tanpa persetujuan tim.
- Seeder untuk data pengujian harus dibedakan dari data production yang diperlukan aplikasi.

### 4.6 Initial Setup After Cloning

Setiap developer yang baru melakukan clone repository wajib menyiapkan environment lokalnya sendiri.

Langkah-langkah:

**1. Install dependency backend**

```bash
composer install
```

**2. Install dependency frontend**

```bash
npm install
```

**3. Buat file environment**

Linux/macOS:

```bash
cp .env.example .env
```

Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

**4. Konfigurasikan `.env`**

Isi konfigurasi sesuai database dan environment yang digunakan.

Jangan mengunggah `.env` ke Git.

**5. Generate application key**

```bash
php artisan key:generate
```

**6. Bersihkan configuration cache**

```bash
php artisan config:clear
```

**7. Periksa status migration**

```bash
php artisan migrate:status
```

**8. Jalankan migration yang belum diterapkan**

```bash
php artisan migrate
```

Perintah tersebut hanya boleh diarahkan ke database yang memang disiapkan untuk developer tersebut atau database bersama setelah migration diperiksa dan disepakati tim.

Jangan langsung menjalankan migration baru ke Aiven hanya karena baru selesai melakukan clone.

**9. Jalankan Seeder jika diperlukan**

```bash
php artisan db:seed
```

Jalankan Seeder hanya jika memang dibutuhkan dan sudah dipastikan aman untuk database yang digunakan.

**10. Jalankan aplikasi**

```bash
php artisan serve
```

Untuk frontend:

```bash
npm run dev
```

---

## 5. Database Structure and Naming

### 5.1 General Rules

- Gunakan nama tabel sesuai struktur database yang telah disepakati.
- Gunakan UUID sebagai primary key sesuai rancangan database.
- Gunakan foreign key untuk menjaga integritas relasi.
- Gunakan tipe data yang sesuai dengan kebutuhan.
- Hindari menyimpan data yang sama berulang kali tanpa alasan.
- Gunakan timestamp untuk mencatat waktu pembuatan dan perubahan data jika dibutuhkan.
- Jangan mengubah nama tabel atau kolom tanpa koordinasi dengan developer terkait.

### 5.2 Main Tables

Tabel utama yang digunakan dalam sistem:

| Tabel | Fungsi |
|---|---|
| `pengguna` | Menyimpan data akun pengguna dan role. |
| `barang` | Menyimpan informasi barang hilang dan temuan. |
| `pengajuan_klaim` | Menyimpan pengajuan klaim kepemilikan barang. |
| `bukti_penyerahan` | Menyimpan catatan atau bukti proses penyerahan barang. |
| `log_audits` | Menyimpan riwayat aktivitas penting dalam sistem. |

Gunakan nama tabel dan kolom sesuai migration yang telah disepakati. Jangan membuat tabel duplikat hanya karena belum menemukan implementasi yang sudah tersedia.

### 5.3 Audit Log Scope

Log Audit digunakan untuk mencatat riwayat aktivitas penting dalam proses Lost and Found.

Cakupan aktivitas:

1. `PENCATATAN_BARANG`
2. `PENGAJUAN_KLAIM`
3. `VERIFIKASI_KLAIM`
4. `PERUBAHAN_STATUS_BARANG`
5. `PENYERAHAN_BARANG`

**Log Audit bukan sistem pencatatan seluruh aktivitas CRUD.**

Secara khusus:
- Pencatatan barang dapat dicatat sebagai aktivitas bisnis.
- Pengajuan klaim dicatat.
- Verifikasi klaim dicatat.
- Perubahan status barang dicatat.
- Penyerahan barang dicatat.
- Perubahan umum atribut barang, penghapusan barang, atau CRUD biasa tidak otomatis menjadi aktivitas Log Audit.

Ketentuan implementasi:

- Catat aktor yang melakukan aktivitas.
- Catat jenis aktivitas atau entitas.
- Catat identitas entitas yang terkait.
- Catat waktu aktivitas.
- Simpan informasi perubahan yang relevan jika dibutuhkan.
- Jangan mencatat password, token, atau informasi autentikasi rahasia.
- Pastikan pencatatan audit dilakukan pada proses bisnis yang sesuai.
- Gunakan transaction apabila perubahan data bisnis dan pencatatan audit harus berhasil secara bersamaan.

---

## 6. Laravel Development Guidelines

### 6.1 MVC Structure

Ikuti pola MVC Laravel:

| Layer | Tanggung Jawab |
|---|---|
| Model | Representasi data, relasi Eloquent, dan interaksi database. |
| View | Tampilan antarmuka menggunakan Blade. |
| Controller | Mengelola request, validasi, pemanggilan proses, dan response. |
| Middleware | Membatasi akses berdasarkan kondisi autentikasi atau role. |
| Migration | Mengelola struktur database. |
| Seeder | Menyediakan data awal atau data pengujian. |

Jangan memindahkan seluruh business logic ke dalam Blade.

### 6.2 Controller

- Gunakan controller untuk mengelola request dan response.
- Gunakan validasi Laravel sebelum menyimpan data.
- Gunakan authorization untuk memeriksa hak akses.
- Hindari controller yang terlalu besar.
- Jangan menuliskan query kompleks berulang kali jika dapat menggunakan relasi atau method yang sudah tersedia.
- Jangan mempercayai data dari frontend tanpa validasi backend.

### 6.3 Model

- Definisikan relasi Eloquent sesuai struktur database.
- Gunakan `$fillable` atau `$guarded` secara tepat.
- Hindari mass assignment yang tidak aman.
- Gunakan casting untuk tipe data yang memang membutuhkan casting.
- Jangan menduplikasi relasi yang sudah tersedia.
- Jangan mengubah nama relasi tanpa memeriksa pemakaiannya di controller dan view.

### 6.4 Blade Views

- Gunakan Blade sebagai templating engine.
- Pisahkan layout, component, dan halaman sesuai kebutuhan.
- Gunakan komponen yang sudah tersedia sebelum membuat komponen duplikat.
- Gunakan `@csrf` pada form yang memerlukan perlindungan CSRF.
- Tampilkan validation error dengan jelas.
- Gunakan escaping Blade untuk output pengguna.
- Hindari penggunaan raw HTML output tanpa sanitasi yang tepat.
- Jangan meletakkan business logic yang kompleks di dalam Blade.

### 6.5 Validation

Setiap input yang berasal dari pengguna harus divalidasi di backend.

Gunakan Laravel Validation, misalnya:

```php
$request->validate([
    'nama_barang' => ['required', 'string', 'max:255'],
    'kategori' => ['required', 'string'],
]);
```

Aturan validasi harus mengikuti kebutuhan masing-masing fitur dan constraint database.

Jangan mengandalkan validasi HTML atau JavaScript saja.

### 6.6 Database Transactions

Gunakan transaction untuk proses yang melibatkan beberapa perubahan data yang saling bergantung.

Contoh penggunaan:
- Verifikasi klaim sekaligus memperbarui status barang.
- Penyelesaian klaim sekaligus mencatat penyerahan barang.
- Perubahan data bisnis sekaligus mencatat Log Audit.

Contoh:

```php
DB::transaction(function () {
    // Proses perubahan data terkait.
});
```

Pastikan transaction tidak mencakup proses eksternal yang tidak perlu dan tidak menyebabkan transaksi database terbuka terlalu lama.

---

## 7. Frontend and UI Guidelines

### 7.1 General UI Rules

- Gunakan Tailwind CSS 4.
- Pertahankan konsistensi desain ant halaman.
- Gunakan layout dan komponen bersama jika memungkinkan.
- Pastikan tampilan responsif untuk desktop, tablet, dan mobile.
- Perhatikan keterbacaan, kontras, spacing, dan hierarki informasi.
- Gunakan komponen yang sudah ada sebelum membuat komponen baru.
- Jangan mengubah keseluruhan desain ketika tugas hanya membutuhkan perubahan kecil.

### 7.2 UI and Backend Separation

Frontend bertanggung jawab terhadap:
- Menampilkan data.
- Mengelola interaksi pengguna.
- Mengirim request.
- Menampilkan feedback.
- Menampilkan error validasi.

Backend tetap bertanggung jawab terhadap:
- Validasi data.
- Authentication.
- Authorization.
- Business logic.
- Integritas data.
- Perubahan status.
- Pencatatan aktivitas penting.

Jangan menjadikan frontend sebagai satu-satunya lapisan keamanan.

### 7.3 UI States

Setiap halaman yang mengambil data atau melakukan operasi harus mempertimbangkan:

- Loading state.
- Empty state.
- Success state.
- Error state.
- Validation state.
- Unauthorized state jika relevan.

Jangan menampilkan data kosong seolah-olah terjadi kesalahan server. Berikan feedback yang sesuai dengan kondisi sebenarnya.

---

## 8. File Ownership and Developer Responsibilities

Pembagian kepemilikan file Sprint 1 digunakan untuk menghindari konflik pekerjaan.

| Developer | Tanggung Jawab | File/Folder |
|---|---|---|
| HB | Frontend, routing, middleware, dan integrasi tampilan | `routes/web.php`, `bootstrap/app.php`, middleware, `resources/views/**`, `resources/css`, `resources/js`, `public/build` |
| RD | Database structure dan model | `database/migrations/**`, `database/seeders/**`, `app/Models/**` |
| LZ | Pengguna dan authentication | `PenggunaController.php`, `config/auth.php` |
| DM | Pengelolaan barang | `BarangController.php`, `Satpam/BarangController.php` |

### 8.1 Ownership Rules

1. Developer bertanggung jawab terhadap file yang menjadi kepemilikannya.
2. Developer lain tidak boleh mengubah file tersebut tanpa koordinasi.
3. Jika suatu fitur membutuhkan perubahan lintas kepemilikan, komunikasikan terlebih dahulu.
4. Jangan mengubah file milik developer lain hanya untuk mempercepat implementasi tanpa persetujuan.
5. Perubahan yang melibatkan database harus dikoordinasikan dengan RD.
6. Perubahan routing, middleware, atau integrasi view harus dikoordinasikan dengan HB.
7. Perubahan authentication harus dikoordinasikan dengan LZ.
8. Perubahan pengelolaan barang harus dikoordinasikan dengan DM.

Kepemilikan file bukan berarti developer lain tidak boleh membaca atau memberikan review. Aturan ini ditujukan untuk menghindari konflik perubahan dan tanggung jawab implementasi.

---

## 9. Git Workflow and Branch Management

### 9.1 Branch Structure

Gunakan struktur branch berikut:

| Branch | Fungsi |
|---|---|
| `main` | Kode production yang stabil dan siap deployment. |
| `dev` | Integrasi seluruh fitur dan pengujian sebelum masuk production. |
| `feat/*` | Pengembangan fitur baru. |
| `fix/*` | Perbaikan bug. |
| `chore/*` | Perubahan konfigurasi, dependency, dan maintenance. |
| `refactor/*` | Restrukturisasi kode tanpa mengubah perilaku fitur. |
| `docs/*` | Perubahan dokumentasi. |
| `test/*` | Penambahan atau perbaikan testing. |

### 9.2 Branch Naming Convention

Gunakan format:

```text
<type>/<short-description>
```

Contoh:

```text
feat/migration-table-pengguna
feat/authentication-login
feat/public-item-catalog
feat/claim-submission
fix/claim-status-validation
fix/item-detail-access
chore/update-dependencies
refactor/barang-controller
docs/update-agents
test/claim-verification
```

Branch boleh menggunakan nested path jika memang membantu pengelompokan:

```text
feat/auth/login
feat/barang/public-catalog
fix/claim/status-validation
```

Ketentuan:
- Gunakan huruf kecil.
- Pisahkan kata dengan tanda hubung (`-`).
- Gunakan prefix sesuai jenis pekerjaan.
- Hindari nama yang terlalu umum seperti `update`, `development`, atau `my-branch`.
- Satu branch sebaiknya berfokus pada satu pekerjaan atau satu fitur yang berkaitan.

### 9.3 Starting a New Task

Sebelum memulai pekerjaan baru:

1. Pastikan tidak sedang berada di branch `main`.
2. Pindah ke branch `dev`.
3. Ambil perubahan terbaru dari remote.
4. Pastikan working tree bersih atau perubahan lokal sudah diamankan.
5. Buat branch baru dari `dev` yang sudah diperbarui.

Contoh:

```bash
git switch dev
git pull origin dev
git switch -c feat/nama-fitur
```

Jangan membuat branch fitur baru dari `main` jika pekerjaan tersebut ditujukan untuk integrasi ke `dev`.

### 9.4 Commit Rules

Gunakan format commit:

```text
<type>: <short-description>
```

Contoh:

```bash
git commit -m "feat: add public item catalog"
git commit -m "fix: prevent unauthorized claim access"
git commit -m "chore: update project dependencies"
git commit -m "docs: update database guidelines"
```

Prefix yang diperbolehkan:
- `feat`
- `fix`
- `chore`
- `refactor`
- `docs`
- `test`
- `style`
- `perf`

Ketentuan:
- Commit harus menggambarkan perubahan yang dilakukan.
- Hindari commit message seperti `update`, `fix`, atau `final`.
- Jangan mencampurkan perubahan yang tidak berkaitan dalam satu commit.
- Jangan memasukkan `.env`, credential, file secret, atau konfigurasi pribadi.
- Bahasa commit dapat menggunakan bahasa Inggris atau Indonesia selama jelas dan konsisten.

### 9.5 Push and Pull Request

Setelah pekerjaan selesai:

```bash
git add .
git commit -m "feat: add nama-fitur"
git push -u origin feat/nama-fitur
```

Kemudian:

1. Buat Pull Request dari branch fitur menuju `dev`.
2. Jelaskan tujuan perubahan.
3. Cantumkan file atau bagian yang berubah.
4. Cantumkan cara pengujian.
5. Periksa hasil review dan selesaikan konflik jika ada.
6. Merge hanya setelah perubahan siap dan telah diperiksa.

Jangan merge pekerjaan yang belum selesai atau belum diuji hanya untuk mempercepat integrasi.

### 9.6 After Feature Branch Is Merged

Setelah branch fitur berhasil di-merge ke `dev`:

1. Jangan menggunakan kembali branch fitur tersebut untuk pekerjaan baru.
2. Pindah kembali ke `dev`.
3. Ambil perubahan terbaru.
4. Buat branch baru untuk pekerjaan berikutnya.

Contoh:

```bash
git switch dev
git pull origin dev
git switch -c fix/nama-perbaikan
```

Branch lama dapat dihapus setelah dipastikan sudah tidak dibutuhkan.

### 9.7 Dev to Main Workflow

`main` hanya diperbarui ketika `dev` telah stabil dan siap dirilis.

Alur:

```text
feat/* / fix/* / chore/*
          |
          v
         dev
          |
          v
 Integration & Testing
          |
          v
   Production Review
          |
          v
         main
          |
          v
       Vercel
```

Ketentuan:
- HB bertanggung jawab membuka PR dari `dev` menuju `main`.
- Sebelum merge ke `main`, HB harus melakukan pemeriksaan production bersama tim.
- Jangan melakukan merge ke `main` jika masih terdapat bug kritis atau konflik yang belum diselesaikan.
- Pastikan konfigurasi production dan kebutuhan deployment sudah diperiksa.
- Setelah merge, pastikan deployment Vercel berhasil.

**Jangan melakukan direct push ke `main`.**

---

## 10. Environment and Secret Management

### 10.1 Environment Files

File berikut tidak boleh dimasukkan ke repository:

```text
.env
.env.*
```

Pengecualian hanya untuk file template yang memang disepakati, seperti:

```text
.env.example
```

`.env.example` harus berisi placeholder atau nilai contoh yang aman, bukan credential asli.

### 10.2 Sensitive Information

Jangan commit atau membagikan:

- Database password.
- Aiven credentials.
- Application key production.
- API key.
- Access token.
- Private key.
- Certificate yang bersifat rahasia.
- Credential layanan eksternal.

Jika developer membutuhkan akses database bersama, berikan konfigurasi melalui jalur distribusi secret yang disepakati tim.

Jangan menaruh credential langsung di source code, dokumentasi publik, screenshot, atau commit Git.

### 10.3 Local and Production Environment

Konfigurasi lokal dan production harus dibedakan.

- Environment lokal menggunakan konfigurasi lokal masing-masing developer.
- Database Aiven digunakan sesuai kesepakatan tim.
- Environment production dikonfigurasi melalui environment variables pada platform deployment.
- Jangan mengandalkan file `.env` lokal untuk konfigurasi Vercel.
- Jangan mengaktifkan debug production tanpa alasan dan persetujuan yang jelas.

---

## 11. Build and Deployment Guidelines

### 11.1 Frontend Asset Build

Gunakan perintah:

```bash
npm run build
```

Hasil build Vite disimpan di:

```text
public/build/
```

Karena konfigurasi deployment proyek tidak menjalankan proses build asset Vite secara otomatis, hasil build yang dibutuhkan aplikasi harus tersedia pada repository dan deployment.

Dengan demikian:

1. Jalankan build setelah perubahan frontend.
2. Periksa apakah `public/build/manifest.json` berhasil dibuat.
3. Pastikan asset yang dibutuhkan tersedia.
4. Commit hasil build `public/build/` sesuai konfigurasi proyek.
5. Jangan menghapus direktori build yang masih dibutuhkan oleh deployment.

Jangan menganggap keberhasilan `npm run build` di komputer lokal berarti deployment production otomatis berhasil.

### 11.2 Vercel Deployment

Sebelum deployment:

- Pastikan branch `main` berisi kode yang sudah diperiksa.
- Pastikan environment variables production tersedia.
- Pastikan `APP_KEY` production sudah dikonfigurasi.
- Pastikan konfigurasi database production benar.
- Pastikan file Vite manifest tersedia pada hasil deployment.
- Pastikan tidak ada credential yang tertanam dalam source code.
- Pastikan migration yang dibutuhkan sudah diterapkan secara terkoordinasi.

### 11.3 Deployment Troubleshooting

Jika deployment menghasilkan HTTP 500:

1. Periksa deployment logs Vercel.
2. Identifikasi error sebenarnya.
3. Periksa environment variables.
4. Periksa `APP_KEY`.
5. Periksa koneksi database.
6. Periksa konfigurasi filesystem dan cache.
7. Periksa keberadaan `public/build/manifest.json`.
8. Periksa konfigurasi entry point dan routing Laravel.
9. Perbaiki penyebab berdasarkan log, bukan dengan mengubah konfigurasi secara acak.

Jangan mengubah `vercel.json`, entry point, atau konfigurasi Laravel secara besar-besaran tanpa memahami penyebab error.

---

## 12. Testing and Verification

Sebelum mengajukan Pull Request, developer wajib melakukan pengujian sesuai perubahan.

### 12.1 General Testing

Periksa:
- Apakah fitur berjalan sesuai kebutuhan?
- Apakah validasi berjalan?
- Apakah authorization berjalan?
- Apakah data tersimpan dengan benar?
- Apakah relasi database bekerja?
- Apakah status berubah sesuai business logic?
- Apakah informasi internal tetap terlindungi?
- Apakah fitur lain yang berkaitan tetap berjalan?

### 12.2 Laravel Checks

Gunakan perintah sesuai kebutuhan:

```bash
php artisan route:list
php artisan migrate:status
php artisan config:clear
```

Jika tersedia dan sesuai dengan konfigurasi proyek:

```bash
php artisan test
```

### 12.3 Frontend Build Check

```bash
npm run build
```

Pastikan proses build selesai tanpa error.

### 12.4 Manual Testing

Lakukan pengujian manual terhadap:
- Pengunjung yang belum login.
- Mahasiswa yang sudah login.
- Satpam yang sudah login.
- Pengguna dengan role yang tidak memiliki izin.
- Input valid.
- Input tidak valid.
- Data kosong.
- Kondisi error.
- Perubahan status.

Jangan hanya menguji fitur menggunakan satu akun dengan hak akses tertinggi.

---

## 13. AI Coding Agent Instructions

AI coding agent yang bekerja pada repository ini wajib mengikuti ketentuan berikut.

### 13.1 Before Coding

1. Baca `AGENTS.md` terlebih dahulu.
2. Periksa branch aktif.
3. Periksa struktur proyek.
4. Baca file yang berkaitan dengan tugas.
5. Identifikasi model, migration, controller, middleware, route, dan view yang terlibat.
6. Periksa apakah terdapat implementasi serupa.
7. Pahami pembagian kepemilikan file.

### 13.2 While Coding

- Kerjakan hanya bagian yang relevan dengan permintaan.
- Pertahankan pola kode proyek.
- Jangan mengubah file di luar cakupan tanpa alasan.
- Jangan mengubah aturan bisnis tanpa persetujuan.
- Jangan membuat migration yang bertentangan dengan struktur database saat ini.
- Jangan menjalankan perintah destruktif pada database.
- Jangan mengganti teknologi atau menambahkan dependency tanpa alasan yang kuat.
- Jangan membuat asumsi terhadap data atau relasi yang belum diperiksa.
- Jangan menghapus perubahan lokal yang bukan bagian dari tugas.

### 13.3 After Coding

1. Periksa kembali seluruh perubahan.
2. Periksa apakah ada file yang tidak sengaja berubah.
3. Jalankan pemeriksaan atau testing yang relevan.
4. Periksa hasil build jika perubahan memengaruhi frontend.
5. Jelaskan file yang diubah.
6. Jelaskan perubahan implementasi.
7. Jelaskan cara pengujian.
8. Sebutkan hal yang belum selesai atau risiko yang masih ada.

### 13.4 AI Agent Must Not

AI coding agent dilarang:

- Melakukan direct push ke `main`.
- Menghapus atau mengganti file tanpa alasan yang jelas.
- Menjalankan `migrate:fresh` pada database bersama.
- Menjalankan `migrate:refresh`, `db:wipe`, atau rollback tanpa persetujuan tim.
- Mengubah schema database secara manual melalui MySQL.
- Mengubah file milik developer lain tanpa koordinasi.
- Menghapus data Aiven untuk mempermudah pengujian.
- Menampilkan informasi internal barang kepada pengguna yang tidak berwenang.
- Mengubah status klaim atau barang tanpa mengikuti business logic.
- Menyimpan password dalam bentuk plaintext.
- Memasukkan `.env` atau credential ke repository.
- Menganggap build lokal sebagai bukti deployment berhasil.

---

## 14. Development Checklist

### Sebelum Memulai

- [ ] Membaca `AGENTS.md`.
- [ ] Memastikan branch aktif.
- [ ] Memperbarui branch `dev`.
- [ ] Membuat branch fitur baru.
- [ ] Memeriksa file yang akan diubah.
- [ ] Memeriksa kepemilikan file.
- [ ] Memastikan tidak ada konflik pekerjaan.

### Saat Mengembangkan

- [ ] Mengikuti arsitektur Laravel.
- [ ] Mengikuti aturan business logic.
- [ ] Menggunakan validasi backend.
- [ ] Menggunakan authorization.
- [ ] Mengikuti struktur database.
- [ ] Menggunakan Migration untuk DDL.
- [ ] Menggunakan Seeder untuk data pengujian yang konsisten.
- [ ] Tidak mengubah database bersama tanpa koordinasi.
- [ ] Tidak mengekspos informasi internal barang.
- [ ] Mencatat aktivitas sesuai cakupan Log Audit.

### Sebelum Pull Request

- [ ] Memeriksa seluruh perubahan.
- [ ] Menjalankan testing yang relevan.
- [ ] Menjalankan build frontend jika diperlukan.
- [ ] Memastikan tidak ada secret yang ikut ter-commit.
- [ ] Membuat commit dengan format yang benar.
- [ ] Push branch fitur.
- [ ] Membuat Pull Request menuju `dev`.
- [ ] Menyertakan deskripsi dan hasil pengujian.

### Sebelum Production

- [ ] Branch `dev` sudah stabil.
- [ ] Tidak ada bug kritis yang belum diselesaikan.
- [ ] Migration sudah diperiksa dan disepakati.
- [ ] Environment variables production sudah tersedia.
- [ ] `APP_KEY` production sudah dikonfigurasi.
- [ ] Vite manifest tersedia.
- [ ] HB telah melakukan production review.
- [ ] Pull Request `dev` menuju `main` telah diperiksa.
- [ ] Deployment Vercel berhasil.
- [ ] Aplikasi production telah diuji.

---

## 15. Final Development Principles

Seluruh pengembangan FILKOM Finders harus mengikuti prinsip berikut:

1. **Consistency:** Seluruh developer menggunakan standar struktur dan implementasi yang sama.
2. **Security:** Data pengguna dan informasi internal barang harus terlindungi.
3. **Data Integrity:** Perubahan database harus menjaga konsistensi dan relasi data.
4. **Coordination:** Perubahan yang berdampak terhadap pekerjaan developer lain harus dikoordinasikan.
5. **Maintainability:** Kode harus mudah dibaca, diperbaiki, dan dikembangkan.
6. **Traceability:** Aktivitas bisnis penting harus dapat ditelusuri melalui Log Audit.
7. **Controlled Deployment:** Perubahan production hanya dilakukan setelah proses integrasi dan pemeriksaan.
8. **No Destructive Changes Without Approval:** Tidak boleh melakukan perubahan destruktif terhadap database bersama tanpa persetujuan tim.

**Dokumen ini menjadi acuan utama selama pengembangan FILKOM Finders. Apabila terdapat kebutuhan untuk mengubah aturan, struktur, atau alur kerja yang telah ditetapkan, perubahan harus dibahas dan disepakati bersama tim sebelum diterapkan.**