# PRD — CUANBASE
### Website Informasi Cara Menghasilkan Uang Secara Online

**Versi:** 1.0.0
**Tanggal:** 18 Mei 2026
**Tech Stack:** Laravel 11 · MySQL 8 · Blade · Alpine.js · Tailwind CSS
**Target Tools:** Antigravity (AI Vibe Coding)

---

## 1. Ringkasan Produk

CUANBASE adalah portal informasi berbahasa Indonesia yang menyajikan panduan, daftar platform, artikel, dan sumber daya terpilih tentang cara menghasilkan uang secara online. Seluruh konten dikelola oleh admin melalui panel khusus yang terlindungi autentikasi dua faktor (2FA) menggunakan Google Authenticator.

---

## 2. Skema Warna & Identitas Visual

Palet warna diambil langsung dari logo CUANBASE.

```
Nama Variabel          Hex         Kegunaan
------------------     -------     -------------------------------------------
--color-navy           #0D1B2A     Background utama, navbar, footer
--color-navy-light     #162436     Background card, sidebar, panel sekunder
--color-gold           #F5C518     Aksen utama, CTA button, highlight aktif
--color-gold-dark      #D4A90E     Hover state gold, border aksen
--color-teal           #1DB89A     Aksen sekunder, badge, ikon interaktif
--color-teal-dark      #17967E     Hover state teal
--color-white          #FFFFFF     Teks utama di atas latar gelap
--color-gray-soft      #A8B8C8     Teks sekunder, placeholder
--color-gray-border    #1E2F42     Border, divider
--color-danger         #E05252     Tombol hapus, pesan error
--color-success        #2ECC71     Pesan sukses, status aktif
```

**Tipografi:**
- Display / Heading : `Plus Jakarta Sans` (Bold 700, SemiBold 600)
- Body / Paragraf   : `Inter` (Regular 400, Medium 500)
- Kode / Teknis     : `JetBrains Mono`

**Tone & Estetika:**
Dark-professional dengan aksen emas hangat. Navy dalam sebagai fondasi, gold sebagai titik fokus aksi, teal sebagai panduan navigasi. Hindari tampilan putih polos — gunakan nuansa navy untuk semua surface.

---

## 3. Sitemap Lengkap

```
CUANBASE/
├── PUBLIC
│   ├── /                          → Home
│   ├── /platform                  → Halaman induk Platform (redirect ke sub-menu pertama)
│   │   ├── /platform/survei-berbayar
│   │   ├── /platform/get-paid-to
│   │   ├── /platform/transcription
│   │   ├── /platform/user-testing
│   │   ├── /platform/freelance
│   │   └── /platform/ai-task
│   ├── /artikel                   → Daftar Artikel + Sidebar
│   │   └── /artikel/{slug}        → Detail Artikel
│   ├── /bacaan-rekomendasi        → Daftar Buku Rekomendasi
│   ├── /free-resources            → Daftar Produk Digital Gratis
│   └── /digital-product           → Daftar Produk Digital Berbayar
│
└── ADMIN  (prefix: /hany4dmin)
    ├── /hany4dmin/login           → Halaman Login Admin
    ├── /hany4dmin/2fa             → Halaman Verifikasi Google Authenticator
    ├── /hany4dmin/dashboard       → Dashboard Ringkasan
    ├── /hany4dmin/platform        → Kelola Platform (CRUD per kategori)
    ├── /hany4dmin/artikel         → Kelola Artikel (CRUD + status tayang)
    ├── /hany4dmin/bacaan          → Kelola Bacaan Rekomendasi (CRUD + status tayang)
    ├── /hany4dmin/free-resources  → Kelola Free Resources (CRUD + status tayang)
    ├── /hany4dmin/digital-product → Kelola Digital Product (CRUD + status tayang)
    └── /hany4dmin/kategori        → Kelola Kategori (Artikel / Bacaan / Resources / Produk)
```

---

## 4. Struktur Database (MySQL)

### 4.1 Tabel `admins`
```sql
id                          BIGINT UNSIGNED PK AUTO_INCREMENT
name                        VARCHAR(100)
email                       VARCHAR(150) UNIQUE
password                    VARCHAR(255)          -- bcrypt
two_factor_secret           VARCHAR(255) NULLABLE -- Google Authenticator secret (encrypted)
two_factor_confirmed_at     TIMESTAMP NULLABLE
remember_token              VARCHAR(100) NULLABLE
created_at                  TIMESTAMP
updated_at                  TIMESTAMP
```

### 4.2 Tabel `platform_categories`
```sql
id         BIGINT UNSIGNED PK AUTO_INCREMENT
name       VARCHAR(100)              -- e.g. "Survei Berbayar"
slug       VARCHAR(120) UNIQUE
sort_order TINYINT DEFAULT 0
created_at TIMESTAMP
updated_at TIMESTAMP
```

*Seed data (urutan tetap):*
1. Survei Berbayar → `survei-berbayar`
2. Get-Paid-To (GPT) → `get-paid-to`
3. Transcription → `transcription`
4. User Testing → `user-testing`
5. Freelance → `freelance`
6. AI Task → `ai-task`

### 4.3 Tabel `platforms`
```sql
id                   BIGINT UNSIGNED PK AUTO_INCREMENT
platform_category_id BIGINT UNSIGNED FK → platform_categories.id
logo                 VARCHAR(255)        -- path file logo
name                 VARCHAR(150)
slug                 VARCHAR(170) UNIQUE
short_description    TEXT
access_url           VARCHAR(500)
is_active            TINYINT(1) DEFAULT 1
sort_order           INT DEFAULT 0
created_at           TIMESTAMP
updated_at           TIMESTAMP
```

### 4.4 Tabel `content_categories`
```sql
id         BIGINT UNSIGNED PK AUTO_INCREMENT
type       ENUM('artikel','bacaan','free_resource','digital_product')
name       VARCHAR(100)
slug       VARCHAR(120)
created_at TIMESTAMP
updated_at TIMESTAMP
UNIQUE (type, slug)
```

### 4.5 Tabel `articles`
```sql
id                   BIGINT UNSIGNED PK AUTO_INCREMENT
content_category_id  BIGINT UNSIGNED FK → content_categories.id NULLABLE
title                VARCHAR(255)
slug                 VARCHAR(270) UNIQUE
excerpt              TEXT
body                 LONGTEXT            -- Rich text / HTML
thumbnail            VARCHAR(255) NULLABLE
meta_title           VARCHAR(255) NULLABLE
meta_description     VARCHAR(320) NULLABLE
is_published         TINYINT(1) DEFAULT 0
view_count           INT UNSIGNED DEFAULT 0
published_at         TIMESTAMP NULLABLE
created_at           TIMESTAMP
updated_at           TIMESTAMP
INDEX (is_published, published_at)
INDEX (view_count)
```

### 4.6 Tabel `books` (Bacaan Rekomendasi)
```sql
id                   BIGINT UNSIGNED PK AUTO_INCREMENT
content_category_id  BIGINT UNSIGNED FK → content_categories.id NULLABLE
title                VARCHAR(255)
slug                 VARCHAR(270) UNIQUE
cover_image          VARCHAR(255) NULLABLE
short_description    TEXT
purchase_url         VARCHAR(500)
is_published         TINYINT(1) DEFAULT 0
sort_order           INT DEFAULT 0
created_at           TIMESTAMP
updated_at           TIMESTAMP
```

### 4.7 Tabel `free_resources`
```sql
id                   BIGINT UNSIGNED PK AUTO_INCREMENT
content_category_id  BIGINT UNSIGNED FK → content_categories.id NULLABLE
title                VARCHAR(255)
slug                 VARCHAR(270) UNIQUE
cover_image          VARCHAR(255) NULLABLE
short_description    TEXT
access_url           VARCHAR(500)
is_published         TINYINT(1) DEFAULT 0
sort_order           INT DEFAULT 0
created_at           TIMESTAMP
updated_at           TIMESTAMP
```

### 4.8 Tabel `digital_products`
```sql
id                   BIGINT UNSIGNED PK AUTO_INCREMENT
content_category_id  BIGINT UNSIGNED FK → content_categories.id NULLABLE
title                VARCHAR(255)
slug                 VARCHAR(270) UNIQUE
cover_image          VARCHAR(255) NULLABLE
short_description    TEXT
purchase_url         VARCHAR(500)
is_published         TINYINT(1) DEFAULT 0
sort_order           INT DEFAULT 0
created_at           TIMESTAMP
updated_at           TIMESTAMP
```

---

## 5. Spesifikasi Halaman PUBLIC

### 5.1 Home (`/`)

**Tujuan:** Memperkenalkan CUANBASE dan mengarahkan pengunjung ke konten utama.

**Komponen:**
- **Hero Section**
  - Headline: "Panduan Lengkap Menghasilkan Uang Secara Online"
  - Sub-headline singkat (1–2 kalimat)
  - Tombol CTA: "Lihat Platform" → `/platform/survei-berbayar`
  - Tombol sekunder: "Baca Artikel" → `/artikel`
- **Section Platform Kategori**
  - Grid 6 kartu ikon (satu per kategori platform)
  - Setiap kartu: ikon SVG representatif, nama kategori, link ke halaman kategori
- **Section Artikel Terbaru**
  - Tampilkan 3 artikel terbaru yang sudah tayang
  - Setiap kartu: thumbnail, badge kategori, judul, excerpt singkat, tanggal
  - Tombol "Lihat Semua Artikel" → `/artikel`
- **Section Bacaan Rekomendasi**
  - Tampilkan 4 buku terbaru yang sudah tayang
  - Tombol "Lihat Semua Buku" → `/bacaan-rekomendasi`
- **Section Free Resources**
  - Tampilkan 4 resource terbaru yang sudah tayang
  - Tombol "Lihat Semua" → `/free-resources`
- **Section Digital Product**
  - Tampilkan 4 produk terbaru yang sudah tayang
  - Tombol "Lihat Semua" → `/digital-product`
- **Footer**
  - Logo, tagline, navigasi utama, copyright

---

### 5.2 Platform (`/platform/{slug}`)

**Tujuan:** Menampilkan daftar platform berdasarkan kategori terpilih.

**Komponen:**
- **Navbar dengan Dropdown Platform**
  - Sub-menu dropdown berisi 6 kategori platform
  - Item aktif diberi highlight gold
- **Header Halaman**
  - Nama kategori aktif
  - Deskripsi singkat kategori
- **Grid Kartu Platform**
  - Layout: grid responsif (1 kolom mobile, 2 tablet, 3 desktop)
  - Setiap kartu berisi:
    - Logo platform (gambar, fallback ke inisial jika tidak ada)
    - Nama platform
    - Deskripsi singkat (maks. 2 baris, truncated)
    - Tombol "Kunjungi Platform" → `access_url` (target: `_blank`, rel: `noopener noreferrer`)
  - Jika tidak ada platform: tampilkan pesan "Belum ada platform di kategori ini."
- **Tab atau Side-nav Kategori**
  - Navigasi cepat antar kategori platform

---

### 5.3 Artikel — Daftar (`/artikel`)

**Tujuan:** Menampilkan semua artikel yang sudah tayang dengan opsi filter.

**Komponen:**
- **Filter Kategori** (tab horizontal atau pill-button)
  - "Semua" + daftar kategori artikel
  - Filter bekerja via query string: `/artikel?kategori=nama-slug`
- **Grid Artikel Utama** (2/3 lebar)
  - Layout: 1 kolom mobile, 2 kolom desktop
  - Setiap kartu: thumbnail, badge kategori, judul, excerpt (2 baris), tanggal, jumlah view
  - Pagination (10 artikel per halaman)
- **Sidebar** (1/3 lebar, sticky di desktop)
  - **Artikel Terpopuler:** 5 artikel dengan `view_count` tertinggi
  - **Artikel Terbaru:** 5 artikel dengan `published_at` terbaru
  - Setiap item sidebar: thumbnail kecil, judul, tanggal

---

### 5.4 Artikel — Detail (`/artikel/{slug}`)

**Komponen:**
- **Header Artikel**
  - Thumbnail full-width
  - Badge kategori
  - Judul (H1)
  - Tanggal terbit · Estimasi waktu baca (dihitung dari panjang konten)
- **Body Artikel**
  - Render HTML dari field `body` (sanitized)
  - Gaya tipografi yang nyaman dibaca: `max-width: 72ch`, `line-height: 1.8`
- **Sidebar** (sama seperti halaman daftar artikel)
- **Artikel Terkait**
  - 3 artikel dari kategori yang sama (terbaru)
- **SEO Meta**
  - `<title>`: `{meta_title}` atau `{title} — CUANBASE`
  - `<meta name="description">`: `{meta_description}` atau `{excerpt}`
  - Open Graph tags (og:title, og:description, og:image)
  - Canonical URL
  - Schema.org `Article` JSON-LD
- **View Count:** Tambah +1 setiap kali halaman diakses (dengan rate-limiting per IP, interval 1 jam)

---

### 5.5 Bacaan Rekomendasi (`/bacaan-rekomendasi`)

**Komponen:**
- **Filter Kategori** (pill-button horizontal)
  - Semua + kategori buku
- **Grid Kartu Buku**
  - Layout: 2 kolom mobile, 3–4 kolom desktop
  - Setiap kartu:
    - Gambar cover buku (rasio 3:4, object-cover)
    - Badge kategori
    - Judul buku
    - Deskripsi singkat (3 baris, truncated)
    - Tombol "Beli Sekarang" → `purchase_url` (target: `_blank`)
  - Jika tidak ada data: tampilkan pesan kosong yang informatif

---

### 5.6 Free Resources (`/free-resources`)

**Komponen:**
- **Filter Kategori** (pill-button horizontal)
- **Grid Kartu Resource**
  - Layout: 2 kolom mobile, 3–4 kolom desktop
  - Setiap kartu:
    - Gambar/thumbnail
    - Badge kategori
    - Judul
    - Deskripsi singkat (3 baris, truncated)
    - Tombol "Akses Gratis" → `access_url` (target: `_blank`)

---

### 5.7 Digital Product (`/digital-product`)

**Komponen:**
- **Filter Kategori** (pill-button horizontal)
- **Grid Kartu Produk**
  - Layout: 2 kolom mobile, 3–4 kolom desktop
  - Setiap kartu:
    - Gambar/cover produk
    - Badge kategori
    - Judul
    - Deskripsi singkat (3 baris, truncated)
    - Tombol "Dapatkan Sekarang" → `purchase_url` (target: `_blank`)

---

## 6. Spesifikasi Panel ADMIN (`/hany4dmin/...`)

### 6.1 Login Admin (`/hany4dmin/login`)

**Alur Autentikasi 2FA:**
```
1. Admin buka /hany4dmin/login
2. Masukkan email + password
3. Jika kredensial valid → redirect ke /hany4dmin/2fa
4. Di halaman 2FA: masukkan 6-digit OTP dari Google Authenticator
5. Jika OTP valid → login berhasil → redirect ke /hany4dmin/dashboard
6. Jika OTP salah > 5x dalam 10 menit → lock sementara 15 menit
```

**Spesifikasi Teknis 2FA:**
- Gunakan package: `pragmarx/google2fa-laravel`
- Secret key disimpan ter-encrypt di kolom `two_factor_secret` (gunakan `encrypt()` Laravel)
- Setup awal 2FA (pertama kali): tampilkan QR code untuk dipindai di Google Authenticator
- Sesi 2FA valid selama sesi browser aktif

**Form Login:**
```
- Field: Email (type="email", required)
- Field: Password (type="password", required, toggleable show/hide)
- Tombol: "Masuk"
- Tidak ada link "Lupa Password" di halaman publik
- Rate Limiting: maks. 5 percobaan per IP per 10 menit (throttle middleware)
```

---

### 6.2 Dashboard (`/hany4dmin/dashboard`)

**Komponen:**
- **Kartu Statistik Ringkasan**
  - Total Platform Aktif
  - Total Artikel Tayang
  - Total Bacaan Tayang
  - Total Free Resources Tayang
  - Total Digital Product Tayang
  - Total Artikel (semua status)
- **5 Artikel Terpopuler** (berdasarkan view_count)
- **5 Konten Terbaru Ditambahkan** (lintas semua tipe konten)
- **Navigasi cepat** ke masing-masing modul

---

### 6.3 Kelola Platform (`/hany4dmin/platform`)

**Daftar Platform:**
- Tabel dengan kolom: Logo, Nama, Kategori, Status Aktif, Urutan, Aksi (Edit | Hapus)
- Filter berdasarkan kategori platform
- Tombol "Tambah Platform"

**Form Tambah/Edit Platform:**
```
- Kategori*           : Dropdown (6 pilihan kategori platform)
- Logo Platform*      : Upload gambar (JPG/PNG/WebP, maks. 500KB, auto-resize ke 200x200px)
- Nama Platform*      : text, maks. 150 karakter
- Deskripsi Singkat*  : textarea, maks. 300 karakter
- Link Akses*         : URL, validasi format URL
- Status Aktif        : toggle (aktif/nonaktif)
- Urutan Tampil       : number (untuk sorting manual)
```

**Hapus Platform:** Konfirmasi modal sebelum menghapus.

---

### 6.4 Kelola Artikel (`/hany4dmin/artikel`)

**Daftar Artikel:**
- Tabel: Thumbnail kecil, Judul, Kategori, Status, Tanggal Dibuat, View, Aksi (Edit | Hapus | Toggle Tayang)
- Filter: berdasarkan status (tayang/draft), kategori
- Search: cari berdasarkan judul
- Tombol "Tambah Artikel"

**Form Tambah/Edit Artikel:**
```
- Judul*              : text, maks. 255 karakter
- Slug*               : auto-generate dari judul, bisa diedit manual
- Kategori            : Dropdown (dari content_categories type='artikel') + tombol "+ Buat Kategori Baru"
- Thumbnail           : Upload gambar (JPG/PNG/WebP, maks. 1MB, auto-resize ke 1200x630px)
- Excerpt             : textarea, maks. 320 karakter (preview SEO)
- Isi Artikel*        : Rich Text Editor (TinyMCE atau Trix)
                        Fitur: heading, bold, italic, link, gambar, list, blockquote, kode inline
- Meta Title          : text, maks. 255 karakter (SEO, opsional — fallback ke judul)
- Meta Description    : textarea, maks. 320 karakter (SEO, opsional — fallback ke excerpt)
- Status Tayang       : toggle (Tayang / Draft)
- Tanggal Tayang      : datetime-local (opsional, untuk scheduled publish)
```

---

### 6.5 Kelola Bacaan Rekomendasi (`/hany4dmin/bacaan`)

**Daftar Bacaan:**
- Tabel: Cover kecil, Judul, Kategori, Status, Tanggal Dibuat, Aksi
- Filter: status, kategori
- Tombol "Tambah Buku"

**Form Tambah/Edit Buku:**
```
- Judul*              : text, maks. 255 karakter
- Kategori            : Dropdown (content_categories type='bacaan') + tombol "+ Buat Kategori Baru"
- Gambar Cover        : Upload (JPG/PNG/WebP, maks. 1MB, rasio 3:4 direkomendasikan)
- Deskripsi Singkat*  : textarea, maks. 500 karakter
- Link Pembelian*     : URL
- Status Tayang       : toggle
- Urutan Tampil       : number
```

---

### 6.6 Kelola Free Resources (`/hany4dmin/free-resources`)

**Form Tambah/Edit Free Resource:**
```
- Judul*              : text, maks. 255 karakter
- Kategori            : Dropdown (content_categories type='free_resource') + tombol "+ Buat Kategori Baru"
- Gambar/Thumbnail    : Upload (JPG/PNG/WebP, maks. 1MB)
- Deskripsi Singkat*  : textarea, maks. 500 karakter
- Link Akses*         : URL
- Status Tayang       : toggle
- Urutan Tampil       : number
```

---

### 6.7 Kelola Digital Product (`/hany4dmin/digital-product`)

**Form Tambah/Edit Digital Product:**
```
- Judul*              : text, maks. 255 karakter
- Kategori            : Dropdown (content_categories type='digital_product') + tombol "+ Buat Kategori Baru"
- Gambar/Cover        : Upload (JPG/PNG/WebP, maks. 1MB)
- Deskripsi Singkat*  : textarea, maks. 500 karakter
- Link Pembelian*     : URL
- Status Tayang       : toggle
- Urutan Tampil       : number
```

---

### 6.8 Kelola Kategori (`/hany4dmin/kategori`)

**Fitur:**
- Tab per tipe konten: Artikel | Bacaan | Free Resources | Digital Product
- Tabel: Nama Kategori, Slug, Jumlah Konten, Aksi (Edit | Hapus)
- Catatan: kategori tidak bisa dihapus jika masih memiliki konten terkait (tampilkan pesan error)
- Form tambah/edit: Nama saja (slug auto-generate)

---

## 7. Spesifikasi Teknis Laravel

### 7.1 Struktur Direktori Utama

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Public/
│   │   │   ├── HomeController.php
│   │   │   ├── PlatformController.php
│   │   │   ├── ArticleController.php
│   │   │   ├── BookController.php
│   │   │   ├── FreeResourceController.php
│   │   │   └── DigitalProductController.php
│   │   └── Admin/
│   │       ├── Auth/
│   │       │   ├── LoginController.php
│   │       │   └── TwoFactorController.php
│   │       ├── DashboardController.php
│   │       ├── PlatformController.php
│   │       ├── ArticleController.php
│   │       ├── BookController.php
│   │       ├── FreeResourceController.php
│   │       ├── DigitalProductController.php
│   │       └── CategoryController.php
│   ├── Middleware/
│   │   ├── AdminAuthenticated.php
│   │   └── TwoFactorVerified.php
│   └── Requests/
│       └── Admin/ (Form Request untuk validasi setiap form)
├── Models/
│   ├── Admin.php
│   ├── PlatformCategory.php
│   ├── Platform.php
│   ├── ContentCategory.php
│   ├── Article.php
│   ├── Book.php
│   ├── FreeResource.php
│   └── DigitalProduct.php
└── Services/
    ├── ImageUploadService.php    ← resize & optimize gambar
    ├── SlugService.php           ← generate slug unik
    └── ViewCountService.php      ← rate-limited view counter
```

### 7.2 Routing

```php
// routes/web.php

// --- PUBLIC ROUTES ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/platform/{slug}', [PlatformController::class, 'show'])->name('platform.show');
Route::get('/artikel', [ArticleController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('artikel.show');
Route::get('/bacaan-rekomendasi', [BookController::class, 'index'])->name('bacaan.index');
Route::get('/free-resources', [FreeResourceController::class, 'index'])->name('free-resources.index');
Route::get('/digital-product', [DigitalProductController::class, 'index'])->name('digital-product.index');

// --- ADMIN ROUTES ---
Route::prefix('hany4dmin')->name('admin.')->group(function () {

    // Auth (tidak butuh middleware)
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post')
         ->middleware('throttle:5,10');
    Route::get('/2fa', [TwoFactorController::class, 'show'])->name('2fa');
    Route::post('/2fa', [TwoFactorController::class, 'verify'])->name('2fa.verify');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Protected routes (butuh auth + 2FA)
    Route::middleware(['admin.auth', 'admin.2fa'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('platform', PlatformController::class);
        Route::resource('artikel', ArticleController::class);
        Route::patch('artikel/{id}/toggle', [ArticleController::class, 'toggle'])->name('artikel.toggle');
        Route::resource('bacaan', BookController::class);
        Route::patch('bacaan/{id}/toggle', [BookController::class, 'toggle'])->name('bacaan.toggle');
        Route::resource('free-resources', FreeResourceController::class);
        Route::patch('free-resources/{id}/toggle', [FreeResourceController::class, 'toggle'])
             ->name('free-resources.toggle');
        Route::resource('digital-product', DigitalProductController::class);
        Route::patch('digital-product/{id}/toggle', [DigitalProductController::class, 'toggle'])
             ->name('digital-product.toggle');
        Route::resource('kategori', CategoryController::class);
    });
});
```

### 7.3 Middleware

**`AdminAuthenticated`:** Cek apakah admin sudah login (session `admin_id` ada). Jika tidak → redirect ke `/hany4dmin/login`.

**`TwoFactorVerified`:** Cek apakah sesi 2FA sudah diverifikasi (session `admin_2fa_verified` = true). Jika tidak → redirect ke `/hany4dmin/2fa`.

### 7.4 Package yang Diperlukan

```bash
# Install via Composer
composer require pragmarx/google2fa-laravel    # 2FA Google Authenticator
composer require bacon/bacon-qr-code            # Generate QR Code untuk setup 2FA
composer require intervention/image             # Image resize & optimization
composer require spatie/laravel-sluggable        # Auto-generate slug
composer require mews/purifier                  # Sanitize HTML artikel

# Install via NPM
npm install tailwindcss @tailwindcss/typography alpinejs
```

---

## 8. Optimasi Performance

### 8.1 Database
- Tambahkan index pada kolom yang sering di-query:
  - `articles`: `(is_published, published_at)`, `(view_count DESC)`, `(slug)`
  - `platforms`: `(platform_category_id, is_active)`
  - `books`, `free_resources`, `digital_products`: `(is_published, sort_order)`
- Gunakan Eager Loading (`with()`) untuk menghindari N+1 query
- Query untuk sidebar artikel: cache selama 10 menit

### 8.2 Caching
```php
// Gunakan Laravel Cache (driver: file atau redis)
Cache::remember('sidebar_popular_articles', 600, fn() => ...);   // 10 menit
Cache::remember('sidebar_latest_articles', 300, fn() => ...);    // 5 menit
Cache::remember('platform_categories', 3600, fn() => ...);       // 1 jam
Cache::remember('home_latest_articles', 300, fn() => ...);       // 5 menit
// Bersihkan cache terkait setiap kali admin menyimpan perubahan
```

### 8.3 Aset & Frontend
- Gunakan Vite untuk bundling CSS + JS
- Lazy loading gambar: tambahkan atribut `loading="lazy"` pada semua `<img>`
- Gambar dikonversi ke format WebP saat upload (via Intervention Image)
- Ukuran gambar dioptimalkan: thumbnail artikel maks. 1200x630px, logo platform maks. 200x200px
- CSS Tailwind di-purge untuk produksi (hanya class yang dipakai)

### 8.4 Server
- Aktifkan HTTP caching header: `Cache-Control`, `ETag` untuk aset statis
- Gzip/Brotli compression untuk response HTML/CSS/JS (konfigurasi di Nginx/Apache)
- Gunakan Laravel Route Caching dan Config Caching untuk produksi:
  ```bash
  php artisan route:cache
  php artisan config:cache
  php artisan view:cache
  ```

---

## 9. Optimasi SEO

### 9.1 Meta Tags (Semua Halaman Publik)
```html
<!-- Di blade layout utama: resources/views/layouts/public.blade.php -->
<title>@yield('meta_title', 'CUANBASE — Panduan Menghasilkan Uang Online')</title>
<meta name="description" content="@yield('meta_description', 'Platform informasi terlengkap tentang cara menghasilkan uang online di Indonesia.')">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{{ url()->current() }}">

<!-- Open Graph -->
<meta property="og:title" content="@yield('og_title', 'CUANBASE')">
<meta property="og:description" content="@yield('og_description')">
<meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="id_ID">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
```

### 9.2 Schema.org JSON-LD

**Halaman Detail Artikel:**
```json
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "{judul}",
  "description": "{excerpt}",
  "image": "{thumbnail_url}",
  "datePublished": "{published_at ISO8601}",
  "dateModified": "{updated_at ISO8601}",
  "author": {"@type": "Organization", "name": "CUANBASE"},
  "publisher": {"@type": "Organization", "name": "CUANBASE", "logo": "{logo_url}"}
}
```

**Halaman Platform (per kategori):**
```json
{
  "@context": "https://schema.org",
  "@type": "ItemList",
  "name": "{nama kategori}",
  "itemListElement": [
    {"@type": "ListItem", "position": 1, "name": "{nama platform}", "url": "{access_url}"}
  ]
}
```

### 9.3 Sitemap XML
- Generate otomatis via artisan command atau package
- File: `/sitemap.xml`
- Sertakan: halaman statis, semua artikel tayang, semua halaman platform, bacaan, resources, produk
- Update otomatis setiap kali konten baru ditambahkan/diterbitkan

### 9.4 Robots.txt
```
User-agent: *
Allow: /
Disallow: /hany4dmin/
Sitemap: https://[domain]/sitemap.xml
```

### 9.5 URL Struktur
- Semua URL menggunakan huruf kecil dengan tanda hubung (`-`)
- Tidak ada parameter query untuk halaman konten (gunakan slug)
- Redirect 301 dari URL dengan trailing slash ke tanpa trailing slash (atau konsisten sebaliknya)

---

## 10. Keamanan (Security)

### 10.1 Autentikasi Admin
- Password di-hash menggunakan bcrypt (cost factor: 12)
- 2FA wajib menggunakan Google Authenticator (TOTP RFC 6238)
- Secret key 2FA disimpan ter-encrypt di database (`encrypt()`/`decrypt()` Laravel)
- Rate limiting: maks. 5 percobaan login per IP per 10 menit
- Session admin menggunakan cookie `HttpOnly`, `Secure`, `SameSite=Strict`
- Logout menghancurkan seluruh data sesi: `Session::flush()` + `Auth::logout()`

### 10.2 CSRF Protection
- Semua form POST/PATCH/DELETE menggunakan `@csrf` Blade directive
- Laravel CSRF middleware aktif di semua route (termasuk admin)

### 10.3 Input Sanitization
- Semua input di-validasi via Form Request (`rules()` method)
- Konten HTML artikel di-sanitize menggunakan HTMLPurifier (via `mews/purifier`) sebelum disimpan
- URL pada `access_url` / `purchase_url` divalidasi format URL dan di-sanitize
- Slug di-generate secara server-side, tidak dipercaya dari input langsung

### 10.4 File Upload
- Validasi: hanya `jpg`, `jpeg`, `png`, `webp` yang diterima
- Validasi ukuran: maks. 1MB (2MB untuk thumbnail artikel)
- File diubah nama secara acak (`Str::uuid() . '.webp'`) sebelum disimpan
- Simpan di `storage/app/public/` (bukan di folder `public/` langsung)
- Tambahkan `.htaccess` di folder upload untuk mencegah eksekusi script

### 10.5 Headers HTTP Keamanan
Tambahkan di middleware global:
```php
'X-Content-Type-Options'  => 'nosniff',
'X-Frame-Options'         => 'SAMEORIGIN',
'X-XSS-Protection'        => '1; mode=block',
'Referrer-Policy'         => 'strict-origin-when-cross-origin',
'Content-Security-Policy' => "default-src 'self'; img-src 'self' data: https:; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com",
```

### 10.6 Database
- Gunakan Eloquent ORM dan Laravel Query Builder (mencegah SQL Injection)
- Hindari raw query; jika terpaksa gunakan parameter binding
- Batasi hak akses user MySQL: hanya `SELECT`, `INSERT`, `UPDATE`, `DELETE` pada database aplikasi

### 10.7 Rate Limiting
- Login admin: 5 request per 10 menit per IP
- View counter artikel: 1 hit per IP per artikel per 60 menit (via Cache)
- Halaman publik: 60 request per menit per IP (default Laravel throttle)

### 10.8 Environment
- File `.env` tidak pernah di-commit ke repository
- `APP_DEBUG=false` dan `APP_ENV=production` di server produksi
- Semua key sensitif disimpan di `.env` (DB password, APP_KEY, 2FA config)

---

## 11. Komponen Blade yang Perlu Dibuat

```
resources/views/
├── layouts/
│   ├── public.blade.php          ← Layout utama publik (navbar + footer)
│   └── admin.blade.php           ← Layout panel admin (sidebar + topbar)
├── components/
│   ├── platform-card.blade.php
│   ├── article-card.blade.php
│   ├── book-card.blade.php
│   ├── resource-card.blade.php
│   ├── product-card.blade.php
│   ├── article-sidebar.blade.php
│   ├── category-filter.blade.php  ← Reusable filter pill-buttons
│   └── pagination.blade.php       ← Custom pagination dengan warna brand
├── public/
│   ├── home.blade.php
│   ├── platform/show.blade.php
│   ├── artikel/index.blade.php
│   ├── artikel/show.blade.php
│   ├── bacaan/index.blade.php
│   ├── free-resources/index.blade.php
│   └── digital-product/index.blade.php
└── admin/
    ├── auth/login.blade.php
    ├── auth/2fa.blade.php
    ├── dashboard.blade.php
    ├── platform/index.blade.php
    ├── platform/form.blade.php
    ├── artikel/index.blade.php
    ├── artikel/form.blade.php
    ├── bacaan/index.blade.php
    ├── bacaan/form.blade.php
    ├── free-resources/index.blade.php
    ├── free-resources/form.blade.php
    ├── digital-product/index.blade.php
    ├── digital-product/form.blade.php
    └── kategori/index.blade.php
```

---

## 12. Migrasi Database (Urutan Eksekusi)

```
2026_01_01_000001_create_admins_table.php
2026_01_01_000002_create_platform_categories_table.php
2026_01_01_000003_create_platforms_table.php
2026_01_01_000004_create_content_categories_table.php
2026_01_01_000005_create_articles_table.php
2026_01_01_000006_create_books_table.php
2026_01_01_000007_create_free_resources_table.php
2026_01_01_000008_create_digital_products_table.php
```

### Seeder
```
DatabaseSeeder
├── AdminSeeder              ← Buat 1 akun admin awal
└── PlatformCategorySeeder   ← Isi 6 kategori platform default
```

---

## 13. Checklist Implementasi

### Fase 1 — Setup Proyek
- [ ] Inisialisasi proyek Laravel 11
- [ ] Konfigurasi koneksi MySQL di `.env`
- [ ] Install semua package (Composer + NPM)
- [ ] Konfigurasi Tailwind CSS dengan custom warna CUANBASE
- [ ] Jalankan semua migrasi & seeder

### Fase 2 — Panel Admin
- [ ] Implementasi login admin + middleware autentikasi
- [ ] Implementasi setup & verifikasi 2FA (Google Authenticator)
- [ ] CRUD Kategori (semua tipe konten)
- [ ] CRUD Platform + upload logo
- [ ] CRUD Artikel + rich text editor + toggle tayang
- [ ] CRUD Bacaan Rekomendasi + toggle tayang
- [ ] CRUD Free Resources + toggle tayang
- [ ] CRUD Digital Product + toggle tayang
- [ ] Dashboard dengan statistik ringkasan

### Fase 3 — Halaman Publik
- [ ] Layout publik (navbar dengan dropdown platform, footer)
- [ ] Halaman Home
- [ ] Halaman Platform (per kategori)
- [ ] Halaman Daftar Artikel + Sidebar
- [ ] Halaman Detail Artikel + view count
- [ ] Halaman Bacaan Rekomendasi
- [ ] Halaman Free Resources
- [ ] Halaman Digital Product

### Fase 4 — Optimasi
- [ ] Implementasi caching (sidebar, platform categories, home sections)
- [ ] Implementasi lazy loading gambar
- [ ] Konfigurasi meta tags + Open Graph di semua halaman
- [ ] Implementasi Schema.org JSON-LD (artikel + platform)
- [ ] Generate `sitemap.xml` otomatis
- [ ] Tambahkan `robots.txt`
- [ ] Konfigurasi security headers (middleware)
- [ ] Tes rate limiting (login + view counter)
- [ ] Audit file upload security

### Fase 5 — QA & Deploy
- [ ] Test semua form validasi
- [ ] Test alur 2FA end-to-end
- [ ] Verifikasi semua link eksternal buka di tab baru
- [ ] Test responsivitas di mobile (375px), tablet (768px), desktop (1280px)
- [ ] Jalankan `php artisan route:cache && php artisan config:cache && php artisan view:cache`
- [ ] Verifikasi `APP_DEBUG=false` di produksi
- [ ] Tes performa dengan Lighthouse (target: Performance >= 85, SEO >= 95)

---

## 14. Catatan Penting untuk Antigravity

1. **Nama Proyek Laravel:** `cuanbase`
2. **Prefix Route Admin:** `hany4dmin` — jaga persis seperti ini, jangan diubah
3. **Guard Auth:** Buat guard terpisah bernama `admin` (bukan `web` default) di `config/auth.php`
4. **Storage Link:** Jalankan `php artisan storage:link` setelah setup untuk akses gambar publik
5. **Rich Text Editor:** Gunakan TinyMCE (via CDN) untuk field `body` artikel di admin
6. **Env Variables Tambahan:**
   ```env
   APP_TIMEZONE=Asia/Jakarta
   APP_LOCALE=id
   GOOGLE2FA_WINDOW=1
   GOOGLE2FA_QRCODE_PROVIDER=imagemagick
   ```
7. **Tailwind Config — Warna Custom:**
   ```js
   // tailwind.config.js
   colors: {
     'navy':        '#0D1B2A',
     'navy-light':  '#162436',
     'gold':        '#F5C518',
     'gold-dark':   '#D4A90E',
     'teal':        '#1DB89A',
     'teal-dark':   '#17967E',
     'gray-soft':   '#A8B8C8',
     'gray-border': '#1E2F42',
   }
   ```
8. **Font Google:** Import `Plus Jakarta Sans` dan `Inter` di layout utama
9. **Bahasa Validasi:** Tambahkan file `lang/id/validation.php` untuk pesan error dalam Bahasa Indonesia

---

*PRD ini adalah dokumen hidup. Update sesuai kebutuhan saat implementasi berlangsung.*
*Versi: 1.0.0 — CUANBASE — 18 Mei 2026*
