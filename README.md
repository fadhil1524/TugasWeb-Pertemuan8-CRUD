# Tugas Rutin 8 - CRUD Inventaris (PHP Native + PDO + MySQL)

## Cara menjalankan
1. Jalankan Laragon/XAMPP (Apache + MySQL).
2. Buka phpMyAdmin, tab **Import**, pilih `schema.sql` (otomatis membuat `inventaris_db` + seed).
3. Salin folder ke `www`/`htdocs`, buka `http://localhost/TugasWeb-Pertemuan8-CRUD/`.
4. Kredensial default `root` tanpa password. Ubah lewat environment variable `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` bila perlu.

## Pemenuhan requirement
| # | Requirement | Lokasi |
|---|-------------|--------|
| 1 | DB `inventaris_db`, 3 tabel + FK | `schema.sql` |
| 2 | Minimal 5 seed per tabel | `schema.sql` |
| 3 | PDO Singleton | `config/database.php` |
| 4 | List dengan JOIN | `index.php` |
| 5 | Create + dropdown kategori & supplier | `create.php`, `includes/product_form.php` |
| 6 | Update pre-filled & delete konfirmasi | `edit.php`, `delete.php` |
| 7 | Semua query prepared statements | semua file PHP |
| 8 | Output `htmlspecialchars()` | fungsi `e()` |
| 9 | Flash message + redirect pattern | `flash()`, `pull_flash()` |
| 10 | UI rapi | `assets/style.css` |

Tambahan: `EMULATE_PREPARES = false`, delete via POST + CSRF token, error detail hanya ke `error_log`.
