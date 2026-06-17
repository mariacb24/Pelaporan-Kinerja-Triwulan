# Sistem Informasi Kinerja BPM
**Badan Penjaminan Mutu - Universitas Satria Farma Cendika**

## Cara Install

### Prasyarat
- PHP 8.2+ (XAMPP/Laragon)
- MySQL 8 (aktif di XAMPP)
- Composer

### Langkah Install

**1. Install dependencies:**
```
composer install
```

**2. Setup environment (sudah otomatis ada .env):**
```
php artisan key:generate
```

**3. Buat database `bpm_kinerja` di phpMyAdmin**
- Buka: http://localhost/phpmyadmin
- Klik New → Nama: `bpm_kinerja` → Create

**4. Jalankan migrasi:**
```
php artisan migrate:fresh --seed
```

**5. Jalankan server:**
```
php artisan serve
```

**6. Buka browser:** http://localhost:8000

---

## Akun Default

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@bpm.ac.id | password |
| Operator BPM | operator@bpm.ac.id | password |
| Rektor | rektor@universitas.ac.id | password |

---

## Atau gunakan INSTALL.bat
Klik 2x file `INSTALL.bat` untuk instalasi otomatis di Windows.

---

## Catatan
- File `.env` sudah dikonfigurasi untuk MySQL
- Tidak perlu hapus migration apapun
- Tidak perlu edit config apapun
