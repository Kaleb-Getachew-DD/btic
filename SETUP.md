# DDU BTIC — Setup & Installation Guide

## System Requirements
- PHP >= 8.2
- Composer >= 2.x
- MySQL >= 8.0
- Node.js >= 18.x (for asset compilation, optional)
- Web Server: Nginx or Apache

---

## 1. Clone & Install

```bash
# Clone or copy project
cd /var/www
git clone <repo-url> btic
cd btic

# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

---

## 2. Database Setup

```sql
-- Run in MySQL client
CREATE DATABASE ddu_btic CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'btic_user'@'localhost' IDENTIFIED BY 'StrongPassword!2024';
GRANT ALL PRIVILEGES ON ddu_btic.* TO 'btic_user'@'localhost';
FLUSH PRIVILEGES;
```

Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ddu_btic
DB_USERNAME=btic_user
DB_PASSWORD=StrongPassword!2024
```

---

## 3. Run Migrations & Seeders

```bash
# Run all migrations
php artisan migrate

# Seed the database with sample data
php artisan db:seed

# Or fresh start with seeds
php artisan migrate:fresh --seed
```

### Default Admin Credentials (from seeders)
| Role         | Email                       | Password        |
|--------------|-----------------------------|-----------------|
| Super Admin  | admin@ddu.edu.et            | Admin@2024!     |
| Admin        | manager@btic.ddu.edu.et     | Manager@2024!   |
| Editor       | editor@btic.ddu.edu.et      | Editor@2024!    |

> **Change these passwords immediately after first login!**

---

## 4. Storage & Permissions

```bash
# Create storage symlink (required for uploaded files)
php artisan storage:link

# Set directory permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## 5. Register Middleware (Laravel 11)

The `bootstrap/app.php` is already configured. Verify it contains:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ]);
})
```

---

## 6. Copy Public Assets

```bash
# Copy CSS and JS to public directory (already in place)
# If using Vite:
npm install
npm run build

# Or ensure public/css/app.css, public/css/admin.css,
# public/js/app.js, public/js/admin.js are present
```

---

## 7. Web Server Configuration

### Nginx
```nginx
server {
    listen 80;
    server_name btic.ddu.edu.et;
    root /var/www/btic/public;
    index index.php;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # File upload size
    client_max_body_size 15M;
}
```

### Apache (.htaccess — already in public/)
Laravel ships with a default `.htaccess` for Apache.

---

## 8. Queue & Cache (Production)

```bash
# Cache config, routes, views for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Clear all caches
php artisan optimize:clear
```

---

## 9. Cron Job (Optional — for scheduled tasks)

```bash
# Add to crontab (crontab -e)
* * * * * cd /var/www/btic && php artisan schedule:run >> /dev/null 2>&1
```

---

## Project Structure

```
btic/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Web/           # Public website controllers
│   │   │   └── Admin/         # CMS admin controllers
│   │   ├── Middleware/
│   │   │   └── AdminMiddleware.php
│   │   └── Requests/
│   │       ├── Admin/         # Admin form requests
│   │       └── Web/           # Public form requests
│   ├── Models/
│   │   ├── User.php
│   │   ├── Application.php    # Startup applications
│   │   ├── Cohort.php         # Incubation cohorts
│   │   ├── Startup.php        # Portfolio startups
│   │   ├── News.php           # Blog/news articles
│   │   ├── Program.php        # BTIC programs
│   │   ├── Service.php        # Support services
│   │   ├── TeamMember.php     # Team members
│   │   ├── Setting.php        # Site settings (CMS)
│   │   └── Notification.php   # Internal notifications
│   └── Notifications/
├── database/
│   ├── migrations/            # All table migrations
│   └── seeders/               # Sample data seeders
├── public/
│   ├── css/
│   │   ├── app.css            # Public website styles (DDU colors)
│   │   └── admin.css          # Admin CMS styles
│   └── js/
│       ├── app.js             # Public website JS
│       └── admin.js           # Admin CMS JS
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php  # Public layout
│       │   └── admin.blade.php # Admin layout
│       ├── components/
│       │   ├── navbar.blade.php
│       │   ├── footer.blade.php
│       │   └── admin/
│       │       ├── sidebar.blade.php
│       │       └── topbar.blade.php
│       ├── web/               # All public pages
│       │   ├── home/
│       │   ├── about/
│       │   ├── news/
│       │   ├── startups/
│       │   ├── programs/
│       │   ├── apply/
│       │   └── contact/
│       └── admin/             # All admin CMS pages
│           ├── auth/
│           ├── dashboard/
│           ├── news/
│           ├── startups/
│           ├── applications/
│           ├── programs/
│           ├── services/
│           ├── team/
│           ├── cohorts/
│           ├── settings/
│           └── notifications/
└── routes/
    └── web.php                # All routes
```

---

## Key URLs

| URL                        | Description                  |
|----------------------------|------------------------------|
| `/`                        | Public homepage              |
| `/about`                   | About BTIC page              |
| `/programs`                | Programs & services          |
| `/startups`                | Startup portfolio            |
| `/startups/{slug}`         | Individual startup detail    |
| `/news`                    | News & blog listing          |
| `/news/{slug}`             | Individual article           |
| `/apply`                   | Cohort application form      |
| `/apply/success`           | Application success page     |
| `/contact`                 | Contact page                 |
| `/admin/login`             | Admin login                  |
| `/admin/dashboard`         | Admin dashboard              |
| `/admin/applications`      | Manage applications          |
| `/admin/cohorts`           | Manage cohorts               |
| `/admin/startups`          | Manage startup portfolio     |
| `/admin/news`              | Manage news/blog             |
| `/admin/programs`          | Manage programs              |
| `/admin/services`          | Manage services              |
| `/admin/team`              | Manage team members          |
| `/admin/settings`          | Website settings/CMS         |
| `/admin/notifications`     | Internal notifications       |

---

## Features Summary

### Public Website
- **Homepage** — Hero with 3D card, stats, programs, featured startups, news, team, CTA
- **About** — Mission, vision, values, full team display
- **Programs & Services** — Detailed program cards with benefits
- **Startups Portfolio** — Filterable grid; detail page with metrics for investors
- **News/Blog** — Featured articles, category filter, full article view
- **Apply for Cohort** — 5-step multi-step form with validation
- **Contact** — Contact form with internal notifications

### Admin CMS
- **Secure login** — Auth with role-based access (super_admin, admin, editor)
- **Dashboard** — Live stats, charts (Chart.js), recent applications
- **Application management** — Review, status pipeline, notes, document downloads
- **Cohort management** — Create/manage cohorts with application windows
- **Startup portfolio** — Full CRUD, featured toggle, image upload
- **News/Blog editor** — Rich text editor, publish/draft toggle, SEO fields
- **Programs & Services** — Full CRUD management
- **Team management** — Full CRUD with photo upload
- **Settings/CMS** — Tabbed settings: general, hero, stats, contact, social, branding
- **Notifications** — Internal notification feed for new applications and status changes

### Design & UX
- **DDU Colors**: Crimson `#8C1D35` + Gold `#C8A032` + Navy `#1C2854`
- **3D effects**: Hero card, program cards, startup cards with perspective transforms
- **Fully responsive**: Mobile-first with hamburger menu
- **Performance**: CSS custom properties, lazy loading, minimal dependencies
- **Fonts**: Playfair Display (headings) + DM Sans (body) + JetBrains Mono (code)
