# SISTEM PENDUKUNG KEPUTUSAN UNTUK MENENTUKAN SISWA/I BERPRESTASI DENGAN MENGGUNAKAN METODE PROMETHEE

**Aplikasi berbasis Laravel 12 untuk membantu proses pengambilan keputusan dalam menentukan siswa berprestasi menggunakan metode _PROMETHEE_ (Preference Ranking Organization Method for Enrichment Evaluation).**

---

## 📌 Deskripsi Singkat

Sistem ini melakukan pemeringkatan siswa berdasarkan data nilai dan kehadiran untuk menghasilkan keputusan yang objektif dalam menentukan siswa/i berprestasi dengan pendekatan analisis multi-kriteria berbasis metode PROMETHEE.

### 📥 Kriteria Penilaian:

-   **Nilai Rata-rata per Semester**
-   **Nilai Ekstrakurikuler**
-   **Absensi**
-   **Prestasi**

### 🎯 Tujuan:

Menentukan **ranking siswa** berdasarkan perhitungan **Net Flow tertinggi** menggunakan metode PROMETHEE.

---

## 🖥️ Tampilan Aplikasi

### Halaman Login

![Login](halaman-login.png)

### Halaman Perhitungan

![Perhitungan](halaman-perhitungan.png)

### Halaman Hasil Ranking

![Hasil Ranking](halaman-ranking.png)

### Halaman Penilaian

![Hasil Penilaian](halaman-penilaian.png)

## ⚙️ Persyaratan Sistem

-   PHP 8.x ke atas
-   Composer
-   MySQL
-   Ekstensi PHP:
    -   PDO
    -   Mbstring
    -   Tokenizer
    -   XML
    -   Fileinfo
    -   Zip

---

## 🚀 Cara Instalasi & Menjalankan Proyek

1. **Clone repository:**

    ```bash
    git clone https://github.com/masmutdevofficial/spk-siswa-berprestasi-promethee
    cd spk-promethee
    ```

2. **Copy file `.env`:**

    ```bash
    cp .env.example .env
    ```

3. **Generate application key:**

    ```bash
    php artisan key:generate
    ```

4. **Link storage (wajib):**

    ```bash
    php artisan storage:link
    ```

5. **Buat folder dengan nama seeders `storage/app/seeders`:**

    ```bash
    mkdir -p storage/app/seeders
    ```

6. **Salin file berikut ke folder `storage/app/seeders`:**

    - `penilaian-sd.xlsx`
    - `penilaian-smp.xlsx`
    - `penilaian-sma.xlsx`

7. **Jalankan migrasi dan seeder awal:**

    ```bash
    php artisan migrate
    php artisan db:seed
    ```

8. **Untuk memasukkan data penilaian lengkap dari file Excel:**

    ```bash
    php artisan db:seed --class=DataPenilaianSeeder
    ```

9. **Jalankan server lokal:**

    ```bash
    php artisan serve
    ```

10. **Akses melalui browser:**

    ```
    http://127.0.0.1:8000
    ```

---

## 👥 Akun Login Default

| Role          | Username | Password |
| ------------- | -------- | -------- |
| Admin Sekolah | admin    | admin    |
| Guru          | guru     | guru     |
| Yayasan       | yayasan  | yayasan  |

---

## 📊 Output Sistem

-   Perhitungan lengkap PROMETHEE
-   Net Flow positif dan negatif
-   Ranking akhir siswa
-   Grafik hasil rekomendasi
-   Laporan cetak per sekolah dan yayasan

---

## 🔍 Keywords SEO

```
SPK Siswa Berprestasi, PROMETHEE Laravel, Sistem Pendukung Keputusan Sekolah, Penilaian Prestasi Siswa, Rekomendasi Siswa Terbaik, Net Flow Siswa
```

---

## 📌 Credits

This project is developed and maintained by [Masmut Dev](https://masmutdev.com), a Fullstack Developer from Indonesia. Dedicated to building efficient educational decision systems with clean logic and practical UI/UX.

© 2025 [Masmut Dev](https://masmutdev.com) – All Rights Reserved.
Lisensi: MIT
