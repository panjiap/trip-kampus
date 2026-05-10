# Trip Kampus – Web Marketplace Aggregator

Platform marketplace aggregator yang berfungsi sebagai pusat informasi open trip terverifikasi bagi mahasiswa untuk mencegah risiko penipuan dan meningkatkan efisiensi pemasaran penyelenggara wisata (EO).

## 🌟 Latar Belakang
Mahasiswa sering menghadapi kendala dalam menemukan informasi open trip yang aman dan transparan. TripKampus hadir sebagai solusi digital untuk mempermudah perbandingan opsi wisata sekaligus membantu penyelenggara menjangkau audiens secara efektif melalui satu pintu yang terpusat.

## 🚀 Fitur Utama
- **Autentikasi Pengguna:** Sistem Login & Register untuk mahasiswa dan admin menggunakan manajemen session PHP.
- **Dashboard Admin:** Fitur CRUD lengkap untuk pengelolaan rute, jadwal, dan verifikasi trip.
- **Antarmuka Modern:** Desain responsif menggunakan Tailwind CSS dengan pendekatan utility-first.
- **Integrasi Database:** Manajemen data relasional yang dinamis menggunakan MySQL.

## 🛠️ Tech Stack
- **Bahasa Pemrograman:** PHP Native
- **Database:** MySQL
- **Styling:** Tailwind CSS
- **Environment:** XAMPP / Localhost

## 📂 Struktur Folder
- `/admin` - Panel kontrol pengelola
- `/assets` - Asset visual dan file CSS (Tailwind)
- `/config` - Konfigurasi koneksi database
- `/layout` - Komponen UI reusable (header/footer)
- `index.php` - Halaman utama aplikasi

## ⚙️ Cara Instalasi
1. Clone repositori ini.
2. Pindahkan folder ke direktori `C:/xampp/htdocs/`.
3. Buat database baru bernama `tripkampus` di phpMyAdmin.
4. Impor file `.sql` yang tersedia di folder proyek.
5. Sesuaikan konfigurasi database pada file di folder `/config`.
6. Akses aplikasi melalui `localhost/trip-kampus`.
