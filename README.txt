Real Estate PHP - Panduan Setup
================================

1) Persyaratan
- PHP 7.2+ dengan mysqli, curl, dan GD enabled
- MySQL 5.7+ (atau MariaDB equivalent)
- Web server: Apache/Nginx dengan PHP enabled
- Composer tidak diperlukan (plain PHP project)

2) Clone / Copy
- Letakkan project di web root (contoh: /var/www/html/RealEstate-PHP)
- Pastikan web server user dapat membaca/menulis ke folder upload jika diizinkan

3) Database
- Buat database (contoh: realestatephp)
- Import schema: DATABASE FILE/realestatephp.sql
- Pastikan koneksi database sudah benar

4) Konfigurasi Koneksi Database
- Edit config.php (root) dan admin/config.php
  Atur DB_HOST, DB_USER, DB_PASS, DB_NAME sesuai environment Anda

5) Izin File (jika mengizinkan upload)
- Buat folder upload writable: admin/property/, admin/upload/, images/user/
  Contoh (Linux): chmod -R 775 admin/property admin/upload images/user

6) Akses Admin Panel
- Admin panel tersedia di /admin
- Kredensial default mungkin tercantum di "01 LOGIN DETAILS & PROJECT INFO.txt"
  Ubah password segera setelah login pertama kali

7) URL Frontend
- Homepage: /index.php
- Detail property: /propertydetail.php?pid={id}
- Appointment: /contact_agent.php?pid={id}&aid={agent_id}

8) Penjadwalan Appointment
- User dapat menjadwalkan appointment dengan mengisi form di contact_agent.php
- Konfirmasi akan dikirim ke WhatsApp user dan agent secara otomatis
- Pastikan nomor telepon lengkap dengan kode negara

9) Menjalankan Lokal (Apache + PHP)
- Enable virtual host yang mengarah ke folder project atau gunakan http://localhost/RealEstate-PHP
- Pastikan mod_rewrite enabled jika Anda menambahkan rewrites (tidak wajib)

10) Masalah Umum
- Halaman kosong: aktifkan error reporting di php.ini atau set display_errors=On untuk debugging
- Kesalahan koneksi DB: cek kembali kredensial di config.php
- Kesalahan upload/permission: atur chmod/chown di folder upload
- WhatsApp notification: pastikan nomor telepon format benar dengan kode negara

11) Deployment Checklist
- Atur izin file dengan benar (jangan 777 di production; gunakan 755/775)
- Disable display_errors di production
- Batasi akses ke admin/ dengan kredensial yang kuat
- Konfigurasi HTTPS dan secure cookies untuk sessions

12) Backup
- Database: buat dump database secara berkala (mysqldump)
- Upload: backup folder admin/property, admin/upload, images/user jika menyimpan media user

Silakan sesuaikan path dan setting dengan environment Anda.
