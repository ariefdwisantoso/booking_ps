# Laravel 12 Project Booking PS

## 🚀 Cara Clone dan Instalasi

Ikuti langkah-langkah di bawah ini untuk meng-clone dan menginstal project di lokal Anda.

### 1️⃣ Clone Repository
```sh
git clone https://github.com/ariefdwisantoso/booking_ps.git
cd booking_ps
```

### 2️⃣ Instalasi Dependency
Jalankan perintah berikut untuk menginstal semua dependency Laravel:
```sh
composer install
```

### 3️⃣ Konfigurasi Environment
Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database:
```sh
cp .env.example .env
```
Kemudian jalankan:
```sh
php artisan key:generate
```

### 4️⃣ Setup Database
Pastikan database sudah dibuat, lalu jalankan migrasi:
```sh
php artisan migrate
```

### 5️⃣ Instalasi Frontend (Vite)
Jalankan perintah berikut untuk menginstal dependency frontend:
```sh
npm install
```
Kemudian jalankan Vite:
```sh
npm run dev
```

### 6️⃣ Menjalankan Server
Jalankan perintah berikut untuk menjalankan server Laravel:
```sh
php artisan serve
```
Akses aplikasi di: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

✨ **Selamat mengembangkan!** 🚀
