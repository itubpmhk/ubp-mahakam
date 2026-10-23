# Panduan Instalasi · Website UBP Mahakam (Laravel)

Paket ini **bukan** proyek Laravel lengkap. Isinya file-file yang ditempel ke proyek Laravel baru.
Ikuti langkah di bawah secara berurutan.

---

## 0. Yang perlu ada di laptop

| Kebutuhan | Keterangan |
|---|---|
| **PHP** | Laravel 13 butuh **PHP 8.3+**. Laravel 12 cukup PHP 8.2. Cek: `php -v` |
| **Composer** | https://getcomposer.org — cek: `composer -V` |
| **Node.js LTS** | https://nodejs.org — cek: `node -v` |
| **MySQL / MariaDB** | Sudah ada di Laragon / XAMPP |

> **XAMPP** versi terbarunya masih PHP 8.2 → pakai **Laravel 12** (perintah di langkah 1).
> **Laragon** biasanya sudah PHP 8.3+ → bisa **Laravel 13**.
> Semua kode di paket ini jalan di Laravel 12 maupun 13.

Pastikan ekstensi PHP berikut aktif di `php.ini` (biasanya sudah aktif): `pdo_mysql`, `fileinfo`, `mbstring`, `openssl`, `dom`.

Agar bisa upload video berita sampai 100 MB, ubah di `php.ini` lalu restart Apache/Laragon:
```
upload_max_filesize = 100M
post_max_size = 110M
memory_limit = 256M
```

---

## 1. Buat proyek Laravel baru

Buka terminal (di Laragon: tombol **Terminal**), masuk ke folder kerja (mis. `C:\laragon\www` atau `C:\xampp\htdocs`):

```bash
# PHP 8.3+ (Laragon) → Laravel 13
composer create-project laravel/laravel ubp-mahakam

# PHP 8.2 (XAMPP) → Laravel 12
composer create-project laravel/laravel:^12.0 ubp-mahakam
```

Lalu buka folder `ubp-mahakam` di VS Code.

## 2. Buat database

Buka phpMyAdmin (`http://localhost/phpmyadmin`) atau HeidiSQL, buat database baru:
- Nama: `ubp_mahakam`
- Collation: `utf8mb4_unicode_ci`

## 3. Atur file `.env`

Buka `.env` di proyek, sesuaikan dengan isi **`env-tambahan.txt`** dari paket ini
(bagian `DB_...`, `APP_URL`, `APP_LOCALE`, dan `ADMIN_...`).
Di XAMPP/Laragon standar, user MySQL `root` tanpa password.

## 4. Tempel file dari paket ini

Salin isi folder paket ke folder proyek, **timpa (replace)** jika ditanya:

```
app/            → model, controller, helper
database/       → tabel (migrations) & data awal (seeders)
resources/      → tampilan (views), CSS, JavaScript
routes/web.php  → alamat halaman
public/images/  → logo
scripts/        → pengacak kode saat build
vite.config.js
```

## 5. Pasang paket JavaScript

```bash
npm install
npm install three@0.149.0 lenis @fontsource/plus-jakarta-sans trix
npm install -D javascript-obfuscator
```

Lalu buka `package.json`, ubah baris `"build"` di bagian `"scripts"` menjadi:

```json
"build": "vite build && node scripts/obfuscate.mjs",
```

## 6. Isi database & sambungkan folder upload

```bash
php artisan migrate --seed
php artisan storage:link
```

`migrate --seed` membuat semua tabel, akun admin dari `.env`, dan isi awal landing page.
`storage:link` wajib agar gambar/video yang diunggah bisa tampil.

## 7. Jalankan

Buka **dua** terminal di VS Code:

```bash
# terminal 1
php artisan serve

# terminal 2
npm run dev
```

(Atau cukup satu perintah: `composer run dev`.)

- Situs: **http://localhost:8000**
- Admin: **http://localhost:8000/admin/login** → login dengan `ADMIN_EMAIL` & `ADMIN_PASSWORD` dari `.env`

Segera ganti password di menu **Akun & Admin**.

---

## Fitur panel admin

| Menu | Fungsi |
|---|---|
| **Konten Landing** | Ubah semua teks hero, video YouTube, paragraf "Tentang", 4 kartu angka, judul bagian, kontak, media sosial, tautan footer |
| **Komitmen** | Tambah/ubah/hapus kartu komitmen, pilih ikon, kartu sorotan, urutan, tampil/sembunyi |
| **Berita** | Tulis berita (editor teks), gambar sampul, media tambahan: gambar, video upload, video YouTube, tautan. Status draft/terbit/terjadwal, pratinjau |
| **Portal Aplikasi** | Tambah aplikasi: nama, kategori, deskripsi, URL, thumbnail, urutan. Kategori otomatis jadi tombol filter |
| **Akun & Admin** | Ubah profil, ganti password, tambah/hapus admin lain |

Halaman publik: `/` (landing), `/berita`, `/berita/{judul}`, `/portal`.

Tips judul hero: apit kata dengan bintang untuk mewarnainya biru, contoh `Menjaga terang *Benua Etam*, setiap hari.`

---

## Kalau ada masalah

| Gejala | Solusi |
|---|---|
| `Vite manifest not found` | Jalankan `npm run dev` (saat mengembangkan) atau `npm run build` |
| Gambar upload tidak muncul | Jalankan `php artisan storage:link` dan pastikan `APP_URL` di `.env` sama dengan alamat yang dibuka (mis. `http://localhost:8000`) |
| Upload video gagal / halaman error saat simpan | Naikkan `upload_max_filesize` & `post_max_size` di `php.ini`, restart |
| `419 Page Expired` | Muat ulang halaman lalu kirim lagi (sesi habis) |
| `SQLSTATE[HY000] [1049] Unknown database` | Database `ubp_mahakam` belum dibuat / nama di `.env` beda |
| `could not find driver` | Aktifkan `extension=pdo_mysql` di `php.ini` |
| Lupa password admin | Ubah `ADMIN_PASSWORD` di `.env`, lalu `php artisan db:seed --class=AdminSeeder` |
| Konten tidak berubah setelah disimpan | `php artisan cache:clear` |

---

## Struktur file paket

```
app/Models/            Setting, Commitment, Post, PostMedia, PortalApp
app/Http/Controllers/  Home, News, Portal (publik) + Admin/* (panel admin)
app/Support/           HtmlSanitizer (pembersih HTML berita), Youtube, Text, Uploads
app/Providers/AppServiceProvider.php   membagikan isi "Konten Landing" ke semua halaman
database/migrations/   tabel settings, commitments, posts, post_media, portal_apps
database/seeders/      akun admin + isi awal
resources/views/       layouts/, site/ (publik), admin/ (panel)
resources/js/          site.js, ui.js, world.js (3D), admin.js
resources/css/         site.css, admin.css
```

## Keamanan yang sudah diterapkan

- Login dibatasi 5 percobaan/menit, sesi diperbarui saat login, semua form memakai CSRF token.
- Isi berita dibersihkan dari script/iframe/atribut berbahaya sebelum disimpan (`HtmlSanitizer`).
- Upload dibatasi jenis & ukurannya; link hanya menerima `http(s)://`.
- Halaman admin diberi `noindex` agar tidak muncul di Google.
- Saat produksi: set `APP_ENV=production`, `APP_DEBUG=false` di `.env`.
