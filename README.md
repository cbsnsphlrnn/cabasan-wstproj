# Taskflow

A simple personal task manager built with Laravel, Blade, Tailwind CSS, and SQLite.

**Project Code:** WST21 -12:00-1:30pm-2026-TTH
**Student Name:**  Sophia Lorianne Cabasan
**Course & Year:**  BSIT-2
**Database Used:** SQLite

## Features

- Add Task
- View Tasks
- Edit Task
- Delete Task
- Update Status

## Setup

Requirements: PHP 8.2+, Composer, and a web browser.

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Open `http://localhost:8000`. The app uses SQLite by default, so no separate database server is required. To use MySQL instead, update the `DB_*` values in `.env` before running the migration.

## Laravel flow

Requests travel through `routes/web.php`, into `TaskController`, then through the `Task` Eloquent model to the `tasks` database table before rendering the Blade views in `resources/views/tasks`.
