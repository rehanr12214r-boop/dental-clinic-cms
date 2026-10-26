# 🦷 Dental Appointment System

A complete, single-dentist appointment management system built with Laravel 12 and Tailwind CSS — a public booking portal for patients plus a full admin dashboard for the clinic.

## Features

**Public booking portal**
- One-page booking wizard: treatment → date (Flatpickr) → live availability → patient details → instant confirmation.
- Slot engine with double-booking prevention and a 60-day booking window.

**Admin dashboard** (`/admin`)
- Appointments overview: daily stats bar (total, pending, confirmed, completed, revenue), date/status/search filters and 1-click status actions (Confirm → Check-In → Complete / Cancel / Reopen).
- Patient history modal: click any patient name or phone to see their full appointment history, previous treatments, fees and doctor notes.
- WhatsApp quick actions: Send Confirmation, Send Reminder and (after completion) Request Review — each opens wa.me with a filled template.
- Printable receipt for completed visits (A4 / thermal friendly, `window.print()`).
- Reports & analytics: This Week / This Month / Custom range, revenue and completed-vs-cancelled metrics, top treatments, and CSV export of filtered appointments.
- Doctor schedule management, treatment CRUD with fees/durations, and clinic settings (clinic details, Google review link, WhatsApp templates).

## Tech stack

- Laravel 12 · PHP 8.2
- Tailwind CSS v4 · Vite · vanilla JS (no SPA required)
- SQLite by default (any Laravel-supported database works)

## Getting started

```bash
# 1. Install PHP dependencies
composer install

# 2. Create the environment file and app key
cp .env.example .env        # Windows: copy .env.example .env
php artisan key:generate

# 3. One command: migrate + seed (admin login, weekly schedule, treatments)
php artisan clinic:install

# 4. Build (or watch) front-end assets
npm install
npm run build               # development: npm run dev  (or: composer run dev)

# 5. Serve the app
php artisan serve
```

## Default admin credentials

| Email             | Password   |
| ----------------- | ---------- |
| `admin@clinic.com` | `password` |

Change this password before going live (update the seeder or the `users` table).

## Useful commands

| Command | Purpose |
| ------- | ------- |
| `php artisan clinic:install` | Migrate + seed everything a fresh deployment needs. |
| `php artisan migrate:fresh --seed` | Rebuild the database from scratch. |
| `php artisan test --compact` (or `vendor/bin/pest`) | Run the full test suite. |
| `npm run build` | Production asset build. |
| `vendor/bin/pint` | Code style. |

## Production deployment checklist

1. Set `APP_ENV=production`, `APP_DEBUG=false` and the real `APP_URL` in `.env`.
2. Run `php artisan clinic:install` (it forces migrations + seeders non-interactively).
3. Run `php artisan optimize` to cache config/routes/views.
4. Build assets with `npm ci && npm run build` — never ship the Vite dev server.
5. Point the web server's document root at the `public/` directory.
6. Log in and configure the clinic name, address, phone, Google review link and WhatsApp templates under **Admin → Settings**.
7. Change the default admin password before announcing the portal.
