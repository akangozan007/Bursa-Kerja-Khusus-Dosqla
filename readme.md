Bursa-Kerja-Khusus-Dosqla/
├── .htaccess                   # Routing URL ke index.php
├── index.php                   # Root Entry Point (Router & Dispatcher)
├── config/
│   └── database.php            # Koneksi MySQLi / PDO
├── app/
│   ├── controllers/
│   │   ├── HomeController.php
│   │   ├── AuthController.php
│   │   └── JobController.php
│   ├── models/
│   │   ├── User.php
│   │   └── Job.php
│   └── views/
│       ├── templates/
│       │   ├── header.php
│       │   └── footer.php
│       ├── home.php            # Halaman Landing BKK DOSQLA
│       └── jobs.php
└── public/
    ├── css/
    ├── js/
    └── uploads/                # Bukti bayar & CV


Berdasarkan struktur MVC yang ada, berikut adalah rincian fitur utama yang idealnya tersedia untuk **User Biasa (Pencari Kerja/Alumni)** dan **User Admin**:

**Fitur User Biasa (Pencari Kerja / Alumni)**

* **Autentikasi & Profil**
* Registrasi & Login akun.
* Kelola Data Diri (Upload foto profil, data pendidikan, dan berkas CV ke folder `public/uploads/`).


* **Eksplorasi & Lamaran Kerja**
* Membuka Halaman Landing BKK DOSQLA (`views/home.php`).
* Melihat daftar lowongan pekerjaan (`views/jobs.php`).
* Filter & Pencarian lowongan (berdasarkan kategori, tipe pekerjaan, atau lokasi).
* Melamar pekerjaan dengan melampirkan CV yang telah diunggah.
* Riwayat & Status Lamaran (Melihat status apakah lamaran Diterima, Ditolak, atau Diproses).



---

**Fitur User Admin (Pengelola BKK)**

* **Manajemen Lowongan Kerja (CRUD Job)**
* Menambah lowongan pekerjaan baru (Judul, Deskripsi, Kualifikasi, Tanggal Buka/Tutup).
* Mengedit dan menghapus lowongan yang ada.


* **Manajemen Pelamar & Lamaran**
* Melihat daftar pelamar berdasarkan lowongan kerja.
* Verifikasi & Download berkas CV/dokumen pelamar dari `public/uploads/`.
* Mengubah status lamaran pelamar (Proses / Lolos / Tidak Lolos).


* **Manajemen User**
* Kelola akun user/alumni (Verifikasi akun baru, blokir akun, reset password).


* **Laporan & Dashboard Mini**
* Ringkasan statistik (Jumlah lowongan aktif, total pelamar, jumlah alumni yang terserap kerja).



---

**Rekomendasi File Tambahan pada Struktur Project**

Untuk mendukung fitur-fitur di atas, Anda perlu menambahkan beberapa file view dan controller baru:

* **File View Tambahan (`app/views/`)**:
* `app/views/auth/login.php` & `register.php` (Halaman Autentikasi)
* `app/views/jobs/detail.php` (Detail Lowongan)
* `app/views/admin/dashboard.php` (Dashboard Admin)
* `app/views/admin/jobs_manage.php` (Kelola Job Admin)
* `app/views/admin/applicants.php` (Daftar Pelamar Admin)


* **File Model Tambahan (`app/models/`)**:
* `app/models/Application.php` (Untuk menangani logika data lamaran kerja)