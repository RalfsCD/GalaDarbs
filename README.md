# PostPit

PostPit is a Laravel social community platform created as a qualification exam project. It lets users join interest-based groups, create and read posts, comment, like, report content, follow news updates, manage profiles, and access an admin area for moderation.

## Overview

The project focuses on building a complete, modern web application with authentication, role-based access, content moderation, notifications, and a responsive interface that works well on desktop and mobile devices.

## Features

- User registration, login, password reset, and profile management
- Groups and topics for organizing communities
- Post creation with media support
- Comments, likes, and reporting tools
- News publishing section
- Notifications for user activity
- Admin panel for moderation and user management
- Responsive UI with dark mode support
- Server-side validation with modal-based feedback in the app

## Tech Stack

- Laravel 12
- PHP 8.2+
- MySQL / MariaDB
- Blade templates
- Tailwind CSS
- Alpine.js
- Vite

## Requirements

- PHP 8.2 or newer
- Composer
- Node.js and npm
- MySQL or MariaDB
- A web server such as Apache or Nginx

## Installation

```bash
git clone <repository-url>
cd GalaDarbs
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
```

If you prefer to run the app locally during development:

```bash
php artisan serve
npm run dev
```

## Environment Setup

Update the `.env` file with your local database credentials and application URL. The default setup uses MySQL.

Example:

```env
APP_URL=http://localhost
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=galadarbs
DB_USERNAME=root
DB_PASSWORD=
```

## Testing

```bash
php artisan test
```

## Project Notes

This project was built for a qualification exam, so the focus is on demonstrating full-stack Laravel development, user flow, validation, and a polished interface rather than minimal functionality.

## License

This project is open-source under the MIT license.
