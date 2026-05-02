# Project Absensi Ekstrakurikuler

Web-based extracurricular attendance management system built to help schools manage extracurricular data, member attendance, training schedules, and monthly attendance reports efficiently.

## 📌 Features

### Super Admin
- CRUD Data Ekstrakurikuler
- CRUD Akun Admin
- Rekap Absensi Ekstrakurikuler per Bulan

### Admin
- CRUD Akun Petugas
- CRUD Data Anggota
- CRUD Jadwal Latihan
- Rekap Absensi Bulanan

### Petugas
- Manajemen Absensi Anggota
  - Input kehadiran anggota sesuai ekstrakurikuler
  - Input absensi berdasarkan jadwal latihan

## 🛠️ Tech Stack

- **Framework:** Laravel
- **Authentication:** Laravel Breeze
- **Database:** MySQL
- **Frontend:** Blade Template
- **Styling:** Tailwind CSS

## 📂 Project Structure

```bash
Project-Absensi-Ekstrakurikuler/
│
├── app/
├── database/
├── public/
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
├── routes/
├── storage/
└── artisan
```

## ⚙️ Installation

### 1. Clone Repository
```bash
git clone https://github.com/SalomoOn7/Project-Absensi-Ekstrakurikuler-.git
```

### 2. Move to Project Directory
```bash
cd Project-Absensi-Ekstrakurikuler-
```

### 3. Install Dependencies
```bash
composer install
npm install
```

### 4. Environment Setup
Copy `.env.example` to `.env`

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 5. Configure Database
Set database credentials in `.env`

```env
DB_DATABASE=db_absensi_eskul
DB_USERNAME=root
DB_PASSWORD=
```

Run migration:

```bash
php artisan migrate
```

### 6. Run Development Server
```bash
php artisan serve
npm run dev
```

Access application:

```bash
http://127.0.0.1:8000
```

## 👥 User Roles

| Role | Access |
|---|---|
| Super Admin | Full system management |
| Admin | Operational management |
| Petugas | Attendance management |

## 📊 Workflow

1. Super Admin manages extracurricular data and admin accounts.
2. Admin manages officers, members, and training schedules.
3. Petugas records attendance based on schedules.
4. System generates monthly attendance reports.

## 📸 Screenshots

```md
![Login](public/images/login.png)
![Dashboard](public/images/dashboard.png)
```

## 🚀 Future Improvements

- Export report to PDF/Excel
- Attendance statistics dashboard
- QR Code attendance
- Notification reminder

## Demo Account

Use the following accounts to test each user role:

### Super Admin
```bash
Username: superadmin
Password: superadmin123
```

### Admin
```bash
Email: admin321
Password: admin123
```

### Petugas
```bash
Email: petugas123
Password: petugas321
```

## 👨‍💻 Author

**Salomo Halomoan**

- GitHub: https://github.com/SalomoOn7
