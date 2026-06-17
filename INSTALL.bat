@echo off
title Instalasi Sistem Kinerja BPM
color 0A
echo.
echo  ============================================
echo    SISTEM INFORMASI KINERJA BPM
echo    Instalasi Otomatis
echo  ============================================
echo.

REM Check PHP
php -v >nul 2>&1
if errorlevel 1 (
    echo [ERROR] PHP tidak ditemukan!
    echo Pastikan XAMPP sudah terinstall dan PHP ada di PATH.
    pause
    exit /b 1
)
echo [OK] PHP ditemukan

REM Check Composer
composer -v >nul 2>&1
if errorlevel 1 (
    echo [ERROR] Composer tidak ditemukan!
    echo Download dari https://getcomposer.org/download/
    pause
    exit /b 1
)
echo [OK] Composer ditemukan

echo.
echo [1/6] Install dependencies...
composer install --no-interaction --ignore-platform-reqs
echo.

echo [2/6] Setup environment...
if not exist .env (
    copy .env.example .env
    echo      .env dibuat dari .env.example
) else (
    echo      .env sudah ada, skip
)
echo.

echo [3/6] Generate application key...
php artisan key:generate
echo.

echo [4/6] Bersihkan cache...
php artisan config:clear
php artisan cache:clear
echo.

echo [5/6] Migrasi database...
echo.
echo  PENTING: Pastikan MySQL sudah running di XAMPP
echo  dan database "bpm_kinerja" sudah dibuat di phpMyAdmin!
echo.
pause
php artisan migrate:fresh --seed --force
echo.

echo [6/6] Storage link...
php artisan storage:link
echo.

echo.
echo  ============================================
echo    INSTALASI SELESAI!
echo  ============================================
echo.
echo  Jalankan server dengan perintah:
echo     php artisan serve
echo.
echo  Lalu buka browser:
echo     http://localhost:8000
echo.
echo  Akun Login:
echo     Admin    : admin@bpm.ac.id / password
echo     Operator : operator@bpm.ac.id / password
echo     Pimpinan : rektor@universitas.ac.id / password
echo.
pause
