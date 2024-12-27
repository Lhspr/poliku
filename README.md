# POLIKU
Sistem Temu Janji Dokter untuk Pasien
## Deskripsi
POLIKU adalah sistem manajemen temu janji dokter yang dirancang untuk membantu klinik dalam mengelola jadwal dokter dan pasien secara efisien. Aplikasi ini memungkinkan pasien untuk mendaftar, membuat janji temu, dan mendapatkan informasi jadwal dokter. Sementara itu, pihak klinik dapat mengelola data dokter, pasien, dan jadwal dengan mudah.
## Fitur Utama
- **Registrasi Pasien:** Pasien dapat mendaftar dengan mudah melalui aplikasi.
- **Manajemen Dokter:** Tambah, ubah, atau hapus data dokter.
- **Jadwal Dokter:** Menampilkan jadwal dokter yang tersedia.
- **Pemesanan Janji Temu:** Pasien dapat memilih dokter dan waktu yang diinginkan untuk mendapatkan antrian.
- **Riwayat Periksa:** Pasien dapat melihat riwayat pemeriksaan.
## Teknologi yang Digunakan
- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP
- **Database:** MySQL
## Prasyarat
Pastikan Anda telah menginstal:
- [Laragon](https://laragon.org/) sebagai server lokal, ATAU SERVER LAINNYA .
- Browser modern (Google Chrome, Mozilla Firefox, dll).
## Cara Instalasi
1. Clone repositori ini:
   ```bash
   git clone https://github.com/Lhspr/poliku.git
   ```
2. Pindahkan folder proyek ke direktori `WWW` (jika menggunakan LARAGON):
   ```bash
   mv poliku C:/laragon/www/
   ```
3. Impor database:
   - Buka phpMyAdmin.
   - Buat database baru dengan nama `poli`.
   - Impor file SQL yang ada di folder `database`.
4. Jalankan server lokal:
   - Aktifkan Apache dan MySQL di LARAGON.
   - Tambahkan domain lokal untuk proyek: klik kanan pada ikon laragon di taskbar, pilih "quick add". lalu masukan poliku.test
   - Akses aplikasi melalui browser di `(http://poliku.test/index.php)`.
## Cara Penggunaan
1. **Pasien:**
   - Registrasi akun.
   - Login ke sistem.
   - Pilih dokter dan jadwal yang tersedia.
   - Konfirmasi janji temu.
   - riwayat periksa
2. **Admin Klinik:**
   - Login sebagai admin.
   - Kelola data dokter, pasien, dan jadwal.
   - Pantau laporan dan statistik.
3. **Dokter**
   - Tambah, ubah, atau hapus data dokter.
   - Riwayat pasien
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
