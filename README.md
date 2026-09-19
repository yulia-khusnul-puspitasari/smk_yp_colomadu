# SMK YP Colomadu

Website resmi sekolah SMK Yayasan Pendidikan Colomadu yang mencakup halaman publik, panel admin, panitia penerimaan siswa baru, serta sistem pendaftaran siswa.

## Tentang Project

Project ini dibuat menggunakan:

- PHP native
- MySQL / MariaDB
- Bootstrap 5
- JavaScript
- XAMPP untuk lingkungan lokal

Website ini berfungsi untuk menampilkan profil sekolah, berita, galeri, jurusan, fasilitas, kontak, serta proses pendaftaran siswa baru secara online.

## Fitur Utama

- Halaman depan sekolah
- Profil, sejarah, visi misi, struktur organisasi
- Berita dan galeri
- Informasi jurusan dan program studi
- Formulir pendaftaran siswa baru
- Login untuk admin, panitia, dan siswa
- Manajemen data sekolah, berita, foto, video, serta pendaftaran
- Proses verifikasi dan komentar panitia terhadap pendaftar

## Struktur Folder

```text
smk_yp_colomadu/
├── admin/                 # Panel admin
├── panitia/               # Panel panitia PPDB
├── siswa/                 # Panel siswa
├── config/                # Konfigurasi database
├── includes/              # Header/footer/sidebar reusable
├── assets/                # CSS, JS, gambar, upload asset
├── img/                   # Gambar umum website
├── uploads/               # Berkas upload siswa
├── models/                # Model PHP untuk data
├── vendor/                # Library pihak ketiga
├── index.php              # Halaman utama
├── alumni.php
├── berita.php
├── foto.php
├── profil.php
├── kontak.php
├── video.php
├── spmb/                  # Modul pendaftaran siswa baru
├── smk_yp_colomadu (1).sql # File dump database
├── README.md
└── ...
```

## Persyaratan

Sebelum menjalankan project, pastikan sistem Anda sudah memiliki:

- PHP 8.x
- MySQL/MariaDB
- Apache / XAMPP
- Browser modern

## Cara Menjalankan

### 1. Salin project ke folder web server

Jika menggunakan XAMPP, pindahkan folder project ke folder:

```text
C:/xampp/htdocs/
```

Jadi pathnya menjadi:

```text
C:/xampp/htdocs/smk_yp_colomadu
```

### 2. Buat database MySQL

Buka phpMyAdmin, lalu buat database baru dengan nama:

```text
smk_yp_colomadu
```

Lalu import file SQL berikut:

```text
smk_yp_colomadu (1).sql
```

### 3. Konfigurasi database

Buka file berikut:

```text
config/database.php
```

Sesuaikan konfigurasi jika diperlukan:

```php
$host = '127.0.0.1';
$dbname = 'smk_yp_colomadu';
$user = 'root';
$pass = '';
```

### 4. Jalankan aplikasi

Buka browser dan akses URL berikut:

```text
http://localhost/smk_yp_colomadu/
```

## Akun Default

Berdasarkan file SQL yang ada, akun default yang tersedia antara lain:

### Admin

- Username: `admin`
- Password: `admin111`

### Admin lain

- Username: `yulia`
- Password: `yulia123`

> Catatan: akun ini bersifat contoh dari database dump project. Sebaiknya diganti setelah proses setup awal.

## Login Akses

- Admin: `admin/login.php`
- Panitia: `panitia/login.php`
- Siswa: `siswa/login.php`

## Catatan Penting

- Project ini masih berbasis PHP native dan bukan framework full-stack seperti Laravel atau CodeIgniter.
- Struktur kode masih bersifat modular manual, sehingga untuk pengembangan lebih lanjut perlu dipahami dengan teliti setiap file di folder `admin`, `panitia`, `siswa`, dan `models`.
- Beberapa fitur login dan upload file masih menggunakan pendekatan sederhana dan perlu disesuaikan bila akan dipakai untuk production.

## Kontribusi

Jika Anda ingin mengembangkan project ini lebih lanjut, disarankan untuk:

1. Menyusun struktur folder yang lebih rapi
2. Menggunakan prepared statement secara konsisten
3. Mengamankan password dan session
4. Menambahkan validasi form yang lebih kuat
5. Menangani upload file secara aman

## Lisensi

Project ini dibuat untuk kebutuhan sekolah dan belum disertai lisensi formal yang spesifik.

## Penutup

Project ini cocok untuk kebutuhan website sekolah sederhana yang membutuhkan manajemen profil, berita, dan penerimaan siswa baru berbasis PHP dan MySQL.

Jika Anda ingin, saya juga bisa bantu membuatkan versi README yang lebih formal untuk GitHub, termasuk badge, screenshot, dan struktur project yang lebih lengkap.
