# Buku Tamu Digital - SD Indo Tionghoa Tarakan

Aplikasi Buku Tamu Digital untuk mencatat kunjungan tamu di SD Indo Tionghoa Tarakan. Tamu mengisi data kunjungan melalui form digital, dan admin dapat melihat data, mengelola, serta mengunduh laporan dalam format Word, Excel, atau PDF.

## Fitur Utama

- **Form Tamu** — Tamu mengisi data kunjungan (instansi, tujuan, jumlah personil, PIC, no HP, tanggal & jam kunjungan)
- **Notifikasi Telegram** — Notifikasi otomatis dikirim ke admin/grup Telegram saat ada tamu baru
- **Dashboard Admin** — Melihat daftar tamu, statistik (hari ini, total, notifikasi terkirim), pencarian & filter berdasarkan tanggal
- **Edit & Hapus Data** — Admin dapat mengedit atau menghapus data tamu yang salah
- **Export Laporan** — Unduh data tamu dalam format Word, Excel, atau PDF (dengan logo & kop surat)
- **QR Code** — Generate QR Code yang mengarah ke form tamu untuk dicetak/dibagikan
- **Responsive** — Tampilan optimal di desktop maupun mobile

## Teknologi

| Komponen | Teknologi |
|----------|-----------|
| Backend | Laravel 13 + PHP 8.3 |
| Frontend | Livewire 4 + Tailwind CSS v4 |
| Build Tool | Vite 8 |
| Export Word | PHPWord |
| Export Excel | Maatwebsite Excel |
| Export PDF | DomPDF |
| QR Code | SimpleSoftwareIO QR Code |
| Notifikasi | Telegram Bot API |

## Persiapan

### Kebutuhan Server

- PHP >= 8.3
- Composer
- Node.js & npm (untuk build asset)
- Database (SQLite / MySQL / PostgreSQL)

### Instalasi

```bash
# Clone repository
git clone https://github.com/borughie/btd.tarakanbais.git
cd btd.tarakanbais

# Install dependency PHP
composer install

# Install dependency JS
npm install

# Copy .env
cp .env.example .env

# Generate app key
php artisan key:generate

# Jalankan migrasi
php artisan migrate

# Build asset
npm run build
```

### Konfigurasi `.env`

```env
APP_NAME="Buku Tamu Digital"
APP_URL=https://domain-anda.com

# Database (contoh MySQL)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=username
DB_PASSWORD=password

# Telegram Bot
TELEGRAM_BOT_TOKEN=token_bot_anda
TELEGRAM_CHAT_ID=id_grup_atau_user
```

### Membuat Akun Admin

```bash
php artisan tinker
```

```php
App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@sekolah.com',
    'password' => bcrypt('password_anda'),
]);
```

Ketik `exit` untuk keluar dari tinker.

### Konfigurasi Telegram Bot

1. Buka Telegram, cari **@BotFather**
2. Kirim `/newbot` dan ikuti instruksi untuk membuat bot
3. Salin **Bot Token** yang diberikan
4. Untuk chat ID grup:
   - Buat grup khusus di Telegram
   - Tambahkan bot ke grup tersebut
   - Jadikan bot sebagai **admin grup**
   - Kirim pesan apa pun di grup
   - Buka `https://api.telegram.org/bot<token_bot>/getUpdates` di browser
   - Cari `"chat":{"id":-100xxxxxxxxxx}` — itu adalah chat ID grup
5. Isi `TELEGRAM_BOT_TOKEN` dan `TELEGRAM_CHAT_ID` di `.env`

## Deploy ke Hosting

### Hostinger (atau shared hosting lainnya)

1. Push kode ke GitHub
2. Login ke hosting panel atau SSH
3. Clone repository di folder `public_html` atau subdomain
4. Jalankan:
   ```bash
   composer install --no-dev
   php artisan migrate --force
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
5. Pastikan folder `public/build` ada (sudah ter-commit dari repo)

> **Catatan:** Folder `public/build` sudah termasuk di repository, jadi tidak perlu `npm run build` di server.

## Struktur Aplikasi

```
├── app/
│   ├── Helpers/DateHelper.php          # Format tanggal Indonesia
│   ├── Http/Controllers/               # Export controller (Word, Excel, PDF)
│   ├── Jobs/                           # Kirim notifikasi Telegram
│   ├── Livewire/
│   │   ├── Admin/GuestDashboard.php    # Dashboard admin
│   │   ├── Auth/Login.php              # Halaman login
│   │   └── GuestCheckIn.php            # Form tamu
│   └── Models/Guest.php                # Model tamu
├── database/migrations/                # Migrasi database
├── resources/views/
│   ├── layouts/                        # Layout admin & guest
│   ├── livewire/                       # View Livewire
│   └── exports/                        # Template export PDF
├── routes/web.php                      # Rute aplikasi
└── public/
    ├── img/                            # Logo (logo.png & logo.webp)
    └── build/                          # Asset hasil build
```

## Rute

| Rute | Deskripsi | Akses |
|------|-----------|-------|
| `/` | Form Buku Tamu (untuk tamu) | Publik |
| `/login` | Halaman login admin | Publik |
| `/admin/tamu` | Dashboard admin | Login |
| `/admin/export/word` | Export Word | Login |
| `/admin/export/excel` | Export Excel | Login |
| `/admin/export/pdf` | Export PDF | Login |

## License

MIT
