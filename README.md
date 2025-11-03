# Vault & Shipping Suite

Modern customer portal and admin control center for secure storage and shipment tracking.

## Features
- Customer login to review vault inventory with statuses, locations, and history.
- Real-time shipment tracking feed with timeline updates and destination details.
- Admin dashboard to manage users, add vault items, create shipments, and post tracking events.
- JSON APIs for activity feeds and public tracking lookups.
- Responsive, polished UI built with vanilla PHP and modern CSS.

## Tech Stack
- PHP 8+ (no external dependencies)
- MySQL / MariaDB using PDO
- HTML, CSS, vanilla JavaScript

## Getting Started
1. Create a MySQL database and load `database/migrations/001_initial_schema.sql`.
2. Copy `.env.example` to `.env` and update database credentials and `APP_URL`.
3. Serve the `public/` directory (e.g. `php -S localhost:8000 -t public`).
4. Sign in with `admin@example.com` / `password` and create live users.

## Deploying on cPanel
See `public/docs/setup.html` for a step-by-step hosting guide: database creation, file upload, environment configuration, and permissions checklist.

## Security Checklist
- Change the default admin password immediately.
- Keep `.env` outside the public web root when possible.
- Enable HTTPS and force secure cookies where supported.

## License
MIT License ? 2025
