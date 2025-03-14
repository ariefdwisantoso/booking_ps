# 🚀 Laravel 12 Project Setup Guide

Selamat datang di proyek Laravel 12! Ikuti langkah-langkah berikut untuk menginstal dan menjalankan proyek ini di komputer Anda.  

---

## 📥 Clone Repository

```sh
git clone https://github.com/username/nama-repo.git
cd nama-repo
```

---

## ⚙️ Install Dependencies

Pastikan Anda sudah menginstal **Composer**, lalu jalankan:

```sh
composer install
```

---

## 🔧 Konfigurasi `.env`

Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database:

```sh
cp .env.example .env
```

Kemudian **generate application key**:

```sh
php artisan key:generate
```

---

## 🛠️ Setup Database

Pastikan database sudah dibuat, lalu edit file `.env`:

```sh
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

Setelah itu, jalankan migrasi:

```sh
php artisan migrate
```

---

## ▶️ Menjalankan Aplikasi

Jalankan perintah berikut untuk menjalankan aplikasi:

```sh
php artisan serve
```

Akses proyek di **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 📂 (Opsional) Setup Storage Link

Jika proyek menggunakan file storage, jalankan:

```sh
php artisan storage:link
```

---

## 🎉 Selesai!

Proyek Laravel 12 Anda sudah siap! 🚀  
Happy coding! 😃
