<p align="center">
	<img src="public/images/LogoDark.png" alt="PostPit logo" width="120">
</p>

# PostPit

PostPit is a Laravel social community platform built as a qualification exam project. It brings together groups, posts, comments, news, notifications, and moderation tools in one responsive web app.

<p align="center">
	<em>A clean, exam-ready project focused on real Laravel features and a polished user experience.</em>
</p>

## What It Does

PostPit is designed to show a complete full-stack workflow: users can register, log in, browse topics, create posts, comment, report content, manage profiles, and use the admin area for moderation.

## Main Features

- Authentication, password reset, and profile management
- Groups and topics for organizing communities
- Posts with media uploads
- Comments, likes, and reporting
- News publishing
- Notifications for user activity
- Admin panel for user and report management
- Responsive UI with dark mode support
- Server-side validation with clear feedback in the app

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
- Apache or Nginx

## Setup

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

For local development:

```bash
php artisan serve
npm run dev
```

## Environment

Update the `.env` file with your local database credentials and application URL.

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

## Project Note

This project was created for a qualification exam, so the goal is to demonstrate practical Laravel development, structured validation, and a thoughtful interface rather than only a minimal demo.

## License

MIT License
