# 🎓 Website Tracer Studi — Platform Survei Dinamis dengan Analitik

Platform survei/kuesioner dinamis berbasis Laravel yang dikembangkan untuk keperluan Tracer Study — dikerjakan sebagai bagian dari **Project PKL 2024**. Lebih dari sekadar form statis, sistem ini memungkinkan pembuatan template survei secara fleksibel lengkap dengan dashboard analitik.

## 📌 Deskripsi

Berbeda dari form tracer study konvensional, sistem ini dibangun sebagai **platform pembuat survei (survey builder)**: admin dapat membuat template pertanyaan (`Template`, `Questions`) yang dikelompokkan per kategori (`Kategori`), lalu men-generate form (`Form`) dari template tersebut. Responden mengisi jawaban (`Jawaban`, `answerDetail`), dan hasilnya dapat dianalisis lewat modul analitik khusus.

## ✨ Fitur Utama (berdasarkan struktur kode & dependensi)

- 📝 **Survey Builder** — admin membuat `Template` pertanyaan (`Questions`) yang dikelompokkan per `Kategori`, lalu men-generate `Form` aktif dari template — form tidak hardcode, bisa dibuat ulang untuk survei berbeda
- ✍️ **Pengumpulan Jawaban** — responden mengisi `Jawaban` dengan detail per pertanyaan (`answerDetail`)
- 📈 **Modul Analitik** — `analyticsController` khusus untuk menganalisis hasil survei (berupa grafik/statistik ringkasan)
- 📊 **Tabel Data Interaktif** — menggunakan **yajra/laravel-datatables** untuk menampilkan data besar (respons survei) dengan pencarian, sorting, dan pagination sisi server
- 📤 **Export ke Excel** — **maatwebsite/excel** memungkinkan hasil survei diunduh dalam format Excel untuk analisis lanjutan
- ⚡ **Komponen Reaktif** — **Livewire** digunakan untuk interaktivitas halaman tanpa perlu menulis banyak JavaScript manual
- 👤 **Profil Pengguna** — `ProfileController` untuk manajemen akun

## ⚙️ Teknologi

- **Framework:** Laravel 11 (PHP ^8.2)
- **Reactive UI:** Livewire 3
- **Data Tables:** Yajra Laravel DataTables
- **Export:** Maatwebsite Excel (PhpSpreadsheet wrapper)
- **URL Slug:** cviebrock/eloquent-sluggable

## 🚀 Cara Menjalankan

```bash
git clone https://github.com/dewamardana/Website-Tracer-Studi.git
cd Website-Tracer-Studi
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run dev &
php artisan serve
```

