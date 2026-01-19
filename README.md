# 📸 PresenSee
PresenSee adalah aplikasi presensi berbasis Face Recognition yang mengintegrasikan Laravel (Web/API) dengan Face API (Python) menggunakan teknologi InsightFace untuk proses deteksi dan pengenalan wajah, sehingga mampu mencatat kehadiran peserta secara otomatis, akurat, dan real-time.

## 🧩 Nama Aplikasi
PresenSee

## 🚀 Cara Menggunakan Aplikasi
Alur penggunaan aplikasi PresenSee adalah sebagai berikut:
1. Admin login ke sistem melalui halaman admin.
   Untuk Login Admin (**email** : admin@gmail.com ; **password** : password)
3. Admin menambahkan data peserta.
4. Admin mengatur waktu presensi untuk mengaktifkan presensi.
5. Setelah presensi aktif, peserta masuk ke halaman landing page peserta.
6. Peserta mencari dan memilih nama mereka masing-masing.
7. Sistem akan mengecek apakah data wajah peserta sudah terdaftar.
8. Jika data wajah belum ada, sistem akan menampilkan popup modal alert untuk melakukan registrasi wajah terlebih dahulu.
9. Setelah registrasi wajah berhasil, peserta dapat melakukan presensi.
10. Sistem akan memverifikasi wajah melalui Face API.
11. Jika valid, presensi berhasil dan data kehadiran tercatat di sistem.

Catatan:
- Aplikasi ini harus berjalan dengan dua server aktif:
  - Server Laravel (Web/API)
  - Server Face API (Python)
- Koneksi antar server harus aktif agar proses registrasi dan presensi berjalan normal.

## 🧰 Persyaratan / Requirements
### Laravel Web
Persyaratan:
- PHP >8.x
- Composer
- Node.js & NPM
- Database (MySQL / PostgreSQL)

Instalasi dependency Laravel:
- composer install
- npm install
- php artisan migrate
- php artisan db:seed

### Face API (Python)/InsightFace
Persyaratan:
- Python >3.9
- pip
---
#### Masuk ke direktori Face API
```bash
cd face-api
```
---
Setup virtual environment:
```bash
python -m venv venv
```
---
Aktivasi virtual environment (Windows):
```bash
venv\Scripts\activate
```
---
Upgrade pip dan install dependency:
```bash
pip install --upgrade pip
pip install -r requirements.txt
```

## ⚙️ Langkah Instalasi Awal (Initial Setup)

1. Clone repository:
```bash
https://github.com/Fitriaii/Aplikasi_PresensiWajah
cd presensee
```
2. Konfigurasi Laravel:
- Copy file `.env.example` menjadi `.env`
- Atur database dan URL Face API
```bash
php artisan key:generate
```
3. Setup Face API:
- Masuk ke folder Face API
- Aktifkan virtual environment
- Install semua dependency Python
4. Pastikan Laravel dan Face API dapat saling terhubung.
   
## 💻 Langkah Pengembangan Lokal (Local Development Steps)
Menjalankan Laravel:
```bash
php artisan serve
npm run dev
```
Laravel akan berjalan di:
```bash
http://localhost:8000
```
Menjalankan Face API:
```bash
cd face-api
uvicorn app:app --host 0.0.0.0 --port 5000
```

## 🚀 Langkah Deploy untuk Versi Produksi (Production Deployment Steps)
### Laravel (Production)
1. Install dependency:
```bash
composer install --optimize-autoloader --no-dev
npm run build
```
2. Atur environment production:
```bash
APP_ENV=production
APP_DEBUG=false
```
3. Jalankan migrasi database:
```bash
php artisan migrate --force
```
4. Optimasi aplikasi:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Face API (Production)
1. Aktifkan virtual environment
2. Menjalankan Face API menggunakan Uvicorn (disarankan):
```bash
uvicorn app:app --host 0.0.0.0 --port 5000
```

## 📄 Lisensi

Aplikasi ini digunakan untuk kebutuhan internal, pembelajaran, dan pengembangan sistem presensi.
