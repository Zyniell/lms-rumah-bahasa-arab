# AGENTS.md

## What this is

CodeIgniter **3.1.13** (classic structure) LMS app skeleton ("Rumah Bahasa Arab"). Nearly all framework defaults are still in place — only `Welcome.php` exists in `application/controllers/`; no models, migrations, or custom libraries yet.

Layout: `index.php` (front controller) + `application/` (all app code) + `system/` (framework — **never edit**) + `vendor/` (composer deps).

## Running locally

- Dev stack: **Laragon** (Apache + PHP) on Windows; served at `http://localhost/lms-rumah-bahasa-arab/`. No build step, no dev-server script, no npm.
- **Fix `base_url` before it bites**: `application/config/config.php` still has `http://localhost/BaseFullstackProject/` (copy-paste from a template). Update to match the actual vhost.
- Clean URLs are required: `index_page = ''` plus the root `.htaccess` rewrites everything to `index.php/$1`. Do not delete or "simplify" the root `.htaccess`.
- Environment selection: `$_SERVER['CI_ENV']` (defaults to `development`). See `index.php:56`.

## Code conventions

- **Tabs** for indentation, LF line endings (`.editorconfig`). Match existing files.
- Database (`application/config/database.php`): mysqli, configured for `lms_rumah_bahasa_arab` (user `root`, empty password on Laragon). Schema and seeds live in `database.sql`.
- Autoloaded: `database`, `session`, `form_validation` libraries and `url`, `form`, `html`, `security`, `text`, `youtube` helpers.
- Base controller: `application/core/MY_Controller.php` provides `$currentUser`, `isLoggedIn()`, `requireLogin()`, `requireAdmin()`, `checkRateLimit()`, and `renderView()`.
- Controllers: `Auth.php`, `Home.php`, `Course.php`, `Checkout.php`, `Student.php`, `Classroom.php`, `Admin.php`.
- Models: `User_model`, `Course_model`, `Lesson_model`, `Enrollment_model`, `Transaction_model`, `Progress_model`.
- Frontend: Tailwind CSS via CDN with custom color palette and Amiri Arabic font.

## Gotchas

- Root `.htaccess` blocks direct web access to dotfiles and `.json`/`.md`/`.sql`/`.lock`/`.log` files — intentional security rule; keep it when adding rewrite rules (append before the catch-all `RewriteRule`).
- CSRF Protection is enabled (`csrf_token_rba`) with `csrf_regenerate = FALSE` to prevent AJAX token expiration. Forms must use `form_open()` or include the CSRF input.
- File uploads: stored in `uploads/courses/` and `uploads/payments/`. Protected from script execution by `uploads/.htaccess`.
- Video parsing: handled by `youtube_helper.php` (`extract_youtube_id()`, `youtube_embed_url()`).
- PHP 8.2+ compatibility: dynamic property deprecation is handled; `error_reporting` in `index.php` excludes `E_DEPRECATED`.
