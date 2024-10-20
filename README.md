# Cactus 🌵

Selamat datang di Cactus, sebuah platform tanya jawab yang terinspirasi dari Quora dan Twitter! Di sini, pengguna dapat bertanya, menjawab, dan berbagi pengetahuan dengan cara yang menarik dan interaktif.

## Fitur ✨

- **Tanya Jawab**: Ajukan pertanyaan dan dapatkan jawaban dari pengguna lain.
- **Thread Diskusi**: Terlibat dalam diskusi mendalam mengenai topik tertentu.
- **Notifikasi**: Dapatkan pemberitahuan untuk setiap tanggapan atau interaksi yang relevan.

## Teknologi yang Digunakan 🛠️

- **Laravel**: Framework PHP yang tangguh untuk membangun aplikasi web.
- **Livewire**: Membuat komponen interaktif di Laravel dengan mudah.

## Prerequisites 🛠️

Sebelum memulai, pastikan Anda memiliki:

- PHP 8.3 atau lebih tinggi
- Composer
- MySQL/SQlite
- Node.js 

## Instalasi 📦

Ikuti langkah-langkah berikut untuk menginstal Cactus:

1. **Clone repository**:
   ```bash
   git clone https://github.com/ridzimeko/cactus.git
    ```
2. **Masuk ke direktori proyek**:
   ```bash
   cd cactus
   ```
3. **Instal dependensi**:
   ```bash
   composer install
   ```
4. **Buat file .env**:

   Salin file .env.example ke .env dan sesuaikan dengan pengaturan database Anda.
   ```bash
   cp .env.example .env
   ```
5. **Generate key aplikasi**:
    ```bash
    php artisan key:generate
   ```

6. **Migrasi database**:
    ```bash
    php artisan migrate
    ```
7. **Jalankan server**:
    ```bash
    php artisan serve
    ```

Setelah langkah-langkah di atas, aplikasi akan berjalan di `http://localhost:8000`.
