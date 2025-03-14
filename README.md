<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>README - Instalasi Laravel 12</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 20px; }
        h1, h2 { color: #2c3e50; }
        pre { background: #f4f4f4; padding: 10px; border-radius: 5px; overflow-x: auto; }
        code { color: #c0392b; font-weight: bold; }
        .box { background: #ecf0f1; padding: 15px; border-left: 5px solid #3498db; margin-bottom: 15px; }
    </style>
</head>
<body>

    <h1>📌 Cara Clone dan Instalasi Proyek Laravel 12</h1>

    <div class="box">
        <h2>1️⃣ Clone Repository</h2>
        <p>Jalankan perintah berikut di terminal:</p>
        <pre><code>git clone https://github.com/username/nama-repo.git</code></pre>
    </div>

    <div class="box">
        <h2>2️⃣ Masuk ke Direktori Proyek</h2>
        <pre><code>cd nama-repo</code></pre>
    </div>

    <div class="box">
        <h2>3️⃣ Install Dependency dengan Composer</h2>
        <pre><code>composer install</code></pre>
    </div>

    <div class="box">
        <h2>4️⃣ Copy File .env dan Konfigurasi</h2>
        <pre><code>cp .env.example .env</code></pre>
        <p>Edit file <code>.env</code> sesuai konfigurasi database Anda.</p>
    </div>

    <div class="box">
        <h2>5️⃣ Generate APP_KEY</h2>
        <pre><code>php artisan key:generate</code></pre>
    </div>

    <div class="box">
        <h2>6️⃣ Konfigurasi Database</h2>
        <pre><code>DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
        </code></pre>
        <p>Lalu jalankan migrasi:</p>
        <pre><code>php artisan migrate</code></pre>
    </div>

    <div class="box">
        <h2>7️⃣ Jalankan Server Laravel</h2>
        <pre><code>php artisan serve</code></pre>
        <p>Aplikasi berjalan di: <strong>http://127.0.0.1:8000</strong></p>
    </div>

    <div class="box">
        <h2>8️⃣ (Opsional) Setup Storage Link</h2>
        <pre><code>php artisan storage:link</code></pre>
    </div>

    <div class="box">
        <h2>9️⃣ Selesai! 🎉</h2>
        <p>Proyek Laravel 12 siap digunakan.</p>
    </div>

    <h2>🔥 Happy Coding! 🚀</h2>

</body>
</html>

