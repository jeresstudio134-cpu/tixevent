# TIXEVENT - Nusantara Music Festival 2026

Sistem tiket event sederhana (PHP + Tailwind via CDN). Struktur sudah dipecah
menjadi file-file terpisah agar mudah dirawat.

## Struktur Folder

```
tixevent/
├── index.php                      <- Entry point: routing & layout HTML
├── includes/
│   ├── config.php                 <- Konstanta event, data tiket, fungsi helper
│   ├── actions.php                <- Handler POST: beli tiket, check-in
│   ├── export.php                 <- Handler export CSV data peserta
│   └── components/
│       ├── landing.php            <- Halaman beranda (hero, jingle, video, tiket)
│       ├── modal_purchase.php     <- Modal form pembelian (step 1 & 2)
│       ├── ticket.php             <- Tampilan tiket digital + QR code
│       ├── admin.php              <- Dashboard admin (statistik, filter, tabel)
│       └── scanner.php            <- Gate scanner (cek & check-in tiket)
├── assets/
│   ├── css/
│   │   └── style.css              <- CSS kustom (animasi, pattern dots)
│   ├── js/
│   │   └── script.js              <- JS: autoplay jingle + countdown live
│   └── audio/
│       └── KICAU MANIA.mp3        <- Letakkan file audio jingle di sini
```

## Cara Menjalankan

Project ini butuh PHP (versi 7.4+ disarankan). Jalankan server bawaan PHP dari
dalam folder `tixevent/`:

```bash
php -S localhost:8000
```

Lalu buka `http://localhost:8000` di browser.

## Catatan Perubahan Saat Pemisahan File

- **Export CSV** sekarang dipanggil di awal `index.php` (sebelum ada output
  HTML). Di file asli, pengecekan export ada di paling bawah file setelah
  HTML ter-render, sehingga `header()` untuk download bisa gagal/rusak.
  Pindah ke awal membuat fitur export benar-benar berfungsi.
- **Countdown** sebelumnya hanya dirender sekali oleh PHP (statis, tidak
  jalan). Sekarang ditambahkan `assets/js/script.js` yang membuat countdown
  benar-benar berjalan live tiap detik di browser, memakai data
  `EVENT_DATE_ISO` yang dikirim dari PHP.
- Path audio jingle diubah ke `assets/audio/KICAU MANIA.mp3` agar konsisten
  dengan folder `assets/`. Pindahkan file MP3 Anda ke folder tersebut.

Semua data masih disimpan di PHP **session** (bukan database sungguhan),
sama seperti kode aslinya — jadi data akan hilang saat session berakhir.
