# POLIKLINIK-BK
Sistem Temu Janji Dokter untuk Klinik
## Deskripsi
POLIKLINIK-BK adalah sistem manajemen temu janji dokter yang dirancang untuk membantu klinik dalam mengelola jadwal dokter dan pasien secara efisien. Aplikasi ini memungkinkan pasien untuk mendaftar, membuat janji temu, dan mendapatkan informasi jadwal dokter. Sementara itu, pihak klinik dapat mengelola data dokter, pasien, dan jadwal dengan mudah.
## Fitur Utama
- **Registrasi Pasien:** Pasien dapat mendaftar dengan mudah melalui aplikasi.
- **Manajemen Dokter:** Tambah, ubah, atau hapus data dokter.
- **Jadwal Dokter:** Tampilkan jadwal dokter yang tersedia.
- **Pemesanan Janji Temu:** Pasien dapat memilih dokter dan waktu yang diinginkan.
## Teknologi yang Digunakan
- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP
- **Database:** MySQL
## Prasyarat
Pastikan Anda telah menginstal:
- [XAMPP](https://www.apachefriends.org/index.html) atau server lokal lainnya.
- Browser modern (Google Chrome, Mozilla Firefox, dll).
## Cara Instalasi
1. Clone repositori ini:
   ```bash
   git clone https://github.com/Lhspr/POLIKLINIK-BK.git
   ```
2. Pindahkan folder proyek ke direktori `htdocs` (jika menggunakan XAMPP):
   ```bash
   mv POLIKLINIK-BK /path/to/xampp/htdocs/
   ```
3. Impor database:
   - Buka phpMyAdmin.
   - Buat database baru dengan nama `poli`.
   - Impor file SQL yang ada di folder `database`.
4. Jalankan server lokal:
   - Aktifkan Apache dan MySQL di XAMPP.
   - Akses aplikasi melalui browser di `http://localhost/POLIKLINIK-BK`.
## Cara Penggunaan
1. **Pasien:**
   - Registrasi akun.
   - Login ke sistem.
   - Pilih dokter dan jadwal yang tersedia.
   - Konfirmasi janji temu.
2. **Admin Klinik:**
   - Login sebagai admin.
   - Kelola data dokter, pasien, dan jadwal.
   - Pantau laporan dan statistik.
## Struktur Proyek
```
POLIKLINIK-BK/
├── database/           # File SQL untuk database
├── css/                # File CSS untuk tampilan
├── js/                 # File JavaScript untuk interaksi
├── php/                # File PHP untuk backend
├── img/                # File gambar
├── index.php           # Halaman utama aplikasi
└── README.md           # Dokumentasi proyek
```
## Kontribusi
Kontribusi sangat diterima! Silakan fork repositori ini dan buat pull request untuk fitur baru atau perbaikan bug.
