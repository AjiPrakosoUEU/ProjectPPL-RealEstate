Real Estate PHP - Panduan Setup & Menjalankan Aplikasi
======================================================

PANDUAN CEPAT SETUP LOCALHOST
=============================

1. PERSYARATAN
   - XAMPP / WAMP / MAMP / atau Laragon terinstall
   - PHP 7.2+
   - MySQL 5.7+
   - Browser modern (Chrome, Firefox, Safari, Edge)

2. LANGKAH-LANGKAH SETUP

   A. Download dan Copy Project
      1. Copy folder RealEstate-PHP ke folder htdocs
         - XAMPP: C:\xampp\htdocs\RealEstate-PHP
         - WAMP: C:\wamp\www\RealEstate-PHP
         - MAMP: /Applications/MAMP/htdocs/RealEstate-PHP
         - Laragon: C:\laragon\www\RealEstate-PHP

   B. Setup Database
      1. Buka phpmyadmin (biasanya http://localhost/phpmyadmin)
      2. Buat database baru:
         - Nama: realestatephp
         - Collation: utf8mb4_unicode_ci
      3. Pilih database yang baru dibuat
      4. Klik "Import"
      5. Browse file: DATABASE FILE/realestatephp.sql
      6. Klik "Import" untuk menjalankan

   C. Konfigurasi Database Connection
      1. Buka file: config.php (di root folder)
      2. Cari dan sesuaikan:
         $host = "localhost";
         $user = "root";         // username MySQL (biasanya 'root' untuk localhost)
         $pass = "";             // password MySQL (kosong untuk localhost default)
         $db = "realestatephp";  // nama database yang dibuat

      3. Buka file: admin/config.php
      4. Lakukan konfigurasi yang sama seperti di atas

   D. Start Server
      1. Buka XAMPP/WAMP/Laragon Control Panel
      2. Start Apache dan MySQL
      3. Pastikan status "Running" untuk kedua service

3. AKSES APLIKASI

   A. Halaman Utama
      - URL: http://localhost/RealEstate-PHP/
      - atau http://localhost/RealEstate-PHP/index.php

   B. Admin Panel
      - URL: http://localhost/RealEstate-PHP/admin/
      - Username & Password: cek file "01 LOGIN DETAILS & PROJECT INFO.txt"
      - PENTING: Ubah password admin setelah login pertama!

   C. Halaman Login User
      - URL: http://localhost/RealEstate-PHP/login.php

4. FITUR UTAMA

   A. Browse Properties
      - Homepage menampilkan list properties
      - Klik property untuk melihat detail

   B. Schedule Appointment (Jadwal Janji Temu)
      - Di halaman property detail
      - Klik button "Schedule Appointment"
      - Isi form dengan nama, email, nomor HP, tanggal & waktu
      - Submit form
      - Notifikasi WhatsApp akan dikirim ke user dan agent

   C. Admin Panel
      - Kelola properties (tambah, edit, hapus)
      - Kelola users dan agents
      - Kelola cities dan states
      - Lihat appointment yang masuk

5. TROUBLESHOOTING

   A. Halaman Blank / Error 500
      - Buka config.php
      - Pastikan DB_HOST, DB_USER, DB_PASS, DB_NAME sudah benar
      - Restart Apache & MySQL
      - Cek console browser (F12 > Console)

   B. Database Connection Error
      - Pastikan MySQL sudah running
      - Pastikan database "realestatephp" sudah dibuat
      - Pastikan username/password di config.php benar

   C. Halaman Admin Blank
      - Cek file: admin/config.php
      - Pastikan DB credentials sudah benar

   D. Upload Gambar Gagal
      - Buka folder: admin/property/
      - Pastikan folder bisa ditulis (write permission)
      - Untuk XAMPP: biasanya sudah otomatis bisa ditulis

   E. Login Gagal
      - Pastikan Anda menggunakan kredensial yang benar
      - Cek file: "01 LOGIN DETAILS & PROJECT INFO.txt"
      - Jika lupa password, reset via database (tanya admin)

6. FITUR APPOINTMENT & WHATSAPP

   - Ketika user submit form appointment, sistem otomatis mengirim:
     * Konfirmasi ke WhatsApp user (nomor HP yang diisi di form)
     * Notifikasi ke WhatsApp agent (nomor HP agent)
   
   - Pastikan:
     * Nomor HP format benar (dengan kode negara, contoh: 62812345678)
     * Koneksi internet aktif
     * Endpoint API WhatsApp tersedia

7. DATA DUMMY

   - Database sudah include sample data (properties, users, agents)
   - Gunakan untuk testing sebelum production
   - Bisa ditambah/edit via admin panel

8. DEFAULT CREDENTIALS (cek "01 LOGIN DETAILS & PROJECT INFO.txt")

   Admin Login:
   - Username: admin
   - Password: [cek di file LOGIN DETAILS]

   Test User:
   - Bisa register akun baru via login.php > Register

9. STRUKTUR FOLDER

   RealEstate-PHP/
   ├── admin/           (Admin panel & management)
   ├── css/             (Stylesheet)
   ├── fonts/           (Font files)
   ├── images/          (Image assets)
   ├── include/         (Header & footer templates)
   ├── js/              (JavaScript files)
   ├── webfonts/        (Web fonts)
   ├── DATABASE FILE/   (SQL database file)
   ├── config.php       (Database configuration)
   ├── index.php        (Homepage)
   ├── propertydetail.php  (Property detail page)
   ├── contact_agent.php   (Appointment scheduling page)
   └── ...other pages

10. FILE PENTING

    - config.php              : Database connection settings
    - admin/config.php        : Admin database connection
    - propertydetail.php      : Property detail & appointment button
    - contact_agent.php       : Appointment scheduling form
    - DATABASE FILE/realestatephp.sql : Database schema

11. PERMISSIONS (Linux/Mac)

    Jika folder upload tidak writable:
    chmod -R 755 admin/property
    chmod -R 755 admin/upload
    chmod -R 755 images/user

12. STOP SERVER

    - Buka XAMPP/WAMP/Laragon Control Panel
    - Klik "Stop" untuk Apache dan MySQL
    - Atau tutup application sepenuhnya

13. DEPLOYMENT UNTUK PRODUCTION

    - Ubah DB credentials di config.php dengan production database
    - Pastikan PHP error reporting disabled (display_errors = Off)
    - Gunakan strong password untuk admin
    - Setup HTTPS certificate
    - Backup database secara berkala
    - Monitor WhatsApp API endpoint availability

SELESAI! Aplikasi sekarang siap dijalankan di localhost.

Tips:
- Jangan ubah struktur folder atau nama file utama
- Backup database secara berkala jika ada data penting
- Untuk production, gunakan environment terpisah dengan security lebih ketat
- Pastikan nomor HP agent dan user lengkap untuk WhatsApp notification
