# Project Absensi Ekstrakurikuler

Sistem informasi absensi ekstrakurikuler berbasis web untuk membantu pengelolaan kehadiran siswa pada kegiatan ekstrakurikuler secara lebih efisien dan terorganisir.

## 📌 Fitur Utama

- Login multi-user
- Dashboard admin
- Manajemen data siswa
- Manajemen data ekstrakurikuler
- Absensi kehadiran siswa
- Rekap data absensi
- CRUD data pengguna
- Logout system

## 🛠️ Tech Stack

- **Backend:** PHP Native
- **Frontend:** HTML, CSS, JavaScript
- **Framework CSS:** Tailwind CSS
- **Database:** MySQL

## 📂 Struktur Folder

```bash
Project-Absensi-Ekstrakurikuler/
│
├── admin/
├── user/
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── config/
├── database/
└── index.php
```

## ⚙️ Instalasi

### 1. Clone repository
```bash
git clone https://github.com/SalomoOn7/Project-Absensi-Ekstrakurikuler-.git
```

### 2. Masuk ke folder project
```bash
cd Project-Absensi-Ekstrakurikuler-
```

### 3. Import database
- Buka **phpMyAdmin**
- Buat database baru, misalnya:

```sql
db_absensi_ekstrakurikuler
```

- Import file SQL yang tersedia pada folder database.

### 4. Jalankan project
Pastikan kamu sudah menjalankan:

- Apache
- MySQL

melalui **XAMPP** atau software sejenis.

Akses project di browser:

```bash
http://localhost/Project-Absensi-Ekstrakurikuler-
```

## 👤 Role User

### Admin
- Mengelola data siswa
- Mengelola data ekstrakurikuler
- Mengelola absensi
- Melihat laporan absensi

### User/Siswa
- Login
- Melihat data absensi pribadi

## 📸 Screenshot

Tambahkan screenshot project di sini.

```md
![Dashboard](assets/images/dashboard.png)
```

## 🚀 Future Improvements

- Export laporan PDF
- QR Code attendance
- Notifikasi absensi
- Grafik statistik kehadiran

## 📄 License

Project ini dibuat untuk kebutuhan pembelajaran dan pengembangan pribadi.

## 👨‍💻 Author

**Salomo Halomoan**

- GitHub: https://github.com/SalomoOn7
