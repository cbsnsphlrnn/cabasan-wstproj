# Taskflow

A simple personal task manager built with Laravel, Blade, Tailwind CSS, and SQLite.

**Project Code:** WST21 -12:00-1:30pm-2026-TTH
**Student Name:**  Sophia Lorianne Cabasan
**Course & Year:**  BSIT-2
**Database Used:** SQLite

## Features

- Add Task
<img width="1920" height="903" alt="{F36C06CC-5D34-4E49-9D71-D626F29CC05D}" src="https://github.com/user-attachments/assets/2d6d74bc-47ae-4b07-bdf7-0ca01b4c9d26" />
- View Tasks
<img width="1906" height="920" alt="{427073CD-883E-4DC2-8ACC-A60DF3CF3F54}" src="https://github.com/user-attachments/assets/1a23ea55-e3ec-46cc-a418-6ee92d0ed49c" />
- Edit Task
<img width="1882" height="967" alt="{14F2640B-2A53-4D31-945F-ACD515B4B002}" src="https://github.com/user-attachments/assets/4358bceb-1289-4407-981f-2f8d932e2095" />
- Delete Task
<img width="1904" height="933" alt="{03C880C3-1B4B-4DDE-A006-513C976F7BB7}" src="https://github.com/user-attachments/assets/340f913c-f965-4f32-8940-66cf5bd75bf6" />
- Update Status
<img width="1916" height="752" alt="{638C32F1-23EA-45DC-8684-94EB77E8B9B4}" src="https://github.com/user-attachments/assets/26e460c2-8b60-4580-9aa2-b902463e16df" />

## How system work

**Taskflow Project Guide**

Taskflow is a small personal task manager built with Laravel, Blade, Tailwind CSS, Eloquent, and SQLite.

**1. Main Architecture**

A browser request follows this path:

```text
Browser
  -> public/index.php
  -> bootstrap/app.php
  -> routes/web.php
  -> TaskController
  -> Task Eloquent model
  -> SQLite tasks table
  -> Blade view
  -> HTML response
```

The application has one main domain object: `Task`.

**2. Starting the Application**

Install dependencies and initialize Laravel:

```bash
composer install
cp .env.example .env
php artisan key:generate
mkdir -p database
touch database/database.sqlite
php artisan migrate
php artisan serve --host=0.0.0.0 --port=8000
```

The project uses SQLite by default, so no separate database server is required.

For GitHub Codespaces, open the forwarded HTTPS URL for port 8000. The browser should use an HTTPS address because Codespaces forwards the local HTTP server through HTTPS.

**3. Application Entry Point**

[public/index.php](public/index.php) is the web entry point. It:

1. Loads Composer's autoloader.
2. Loads the Laravel application from `bootstrap/app.php`.
3. Captures the incoming request.
4. Passes the request to Laravel for routing and handling.

[bootstrap/app.php](bootstrap/app.php) configures web routes, console routes, exception handling, and middleware. It also trusts forwarded proxy headers so HTTPS forwarding works correctly in Codespaces.

**4. Routes**

Routes are defined in [routes/web.php](routes/web.php).

| Feature | HTTP method | URL | Controller method |
| --- | --- | --- | --- |
| View tasks | GET | `/` | `index` |
| Create form | GET | `/tasks/create` | `create` |
| Store task | POST | `/tasks` | `store` |
| Edit form | GET | `/tasks/{task}/edit` | `edit` |
| Update task | PUT/PATCH | `/tasks/{task}` | `update` |
| Delete task | DELETE | `/tasks/{task}` | `destroy` |
| Toggle status | PATCH | `/tasks/{task}/status` | `updateStatus` |

The normal `show` route is excluded, so tasks do not have a separate detail page.

**5. Controller Behavior**

The main business logic is in [app/Http/Controllers/TaskController.php](app/Http/Controllers/TaskController.php).

**Listing tasks**

`index()`:

1. Reads the optional `status` query parameter.
2. Filters by `Pending` or `Completed` when requested.
3. Sorts pending tasks before completed tasks.
4. Sorts tasks by due date and then by newest creation time.
5. Calculates total, pending, and completed counts.
6. Renders `tasks.index`.

Examples:

```text
/
/?status=Pending
/?status=Completed
```

**Creating a task**

1. The user opens `/tasks/create`.
2. Laravel renders the create page.
3. The form submits a `POST` request to `/tasks`.
4. The controller validates the fields.
5. Eloquent inserts the task into SQLite.
6. Laravel redirects to the task list with a success message.

**Editing a task**

1. The user clicks **Edit**.
2. Laravel receives `/tasks/{task}/edit`.
3. Route model binding loads the matching `Task` record.
4. The edit form is populated with the existing values.
5. The form submits to `/tasks/{task}` using `PUT` method spoofing.
6. The controller validates and updates the record.
7. Laravel redirects to the task list.

**Deleting a task**

1. The user clicks **Delete**.
2. The form submits a `DELETE` request.
3. The controller deletes the matching record.
4. Laravel redirects to the task list.

**Toggling status**

The status button submits a `PATCH` request to `/tasks/{task}/status`.

The controller switches the value:

```text
Pending   -> Completed
Completed -> Pending
```

**6. Task Model**

The Eloquent model is [app/Models/Task.php](app/Models/Task.php).

The model allows these fields to be mass-assigned:

```text
task_name
description
status
due_date
```

`due_date` is cast to a date object, so views can format it with methods such as:

```php
$task->due_date->format('M j, Y')
```

**7. Database Schema**

The schema is defined in [database/migrations/2026_09_25_000000_create_tasks_table.php](database/migrations/2026_09_25_000000_create_tasks_table.php).

The `tasks` table contains:

| Column | Purpose |
| --- | --- |
| `id` | Primary key |
| `task_name` | Required task title |
| `description` | Optional details |
| `status` | `Pending` or `Completed` |
| `due_date` | Optional due date |
| `created_at` | Creation timestamp |
| `updated_at` | Last update timestamp |

The SQLite database path is configured through `DB_DATABASE` in `.env` and defaults to `database/database.sqlite`.

**8. Views and User Interface**

The shared layout is [resources/views/layouts/app.blade.php](resources/views/layouts/app.blade.php). It contains:

- Navigation and branding
- New task button
- Success messages
- Validation error messages
- Shared page structure

The task list is [resources/views/tasks/index.blade.php](resources/views/tasks/index.blade.php). It displays:

- Task statistics
- Status filters
- Task names and descriptions
- Status labels
- Due dates
- Edit and delete actions
- Status toggle buttons

The create and edit pages are:

- [resources/views/tasks/create.blade.php](resources/views/tasks/create.blade.php)
- [resources/views/tasks/edit.blade.php](resources/views/tasks/edit.blade.php)

Both reuse the input fields in [resources/views/tasks/form.blade.php](resources/views/tasks/form.blade.php).

**9. Validation and Security**

Validation is centralized in `TaskController::validatedData()`:

- `task_name` is required, a string, and limited to 120 characters.
- `description` is optional and limited to 1000 characters.
- `status` must be `Pending` or `Completed`.
- `due_date` must be a valid date when supplied.

Forms include `@csrf`, which protects against cross-site request forgery.

HTML forms only support GET and POST directly, so Laravel method spoofing is used for PUT, PATCH, and DELETE requests:

```blade
@method('PUT')
@method('PATCH')
@method('DELETE')
```

**10. Important Limitations**

- There is no user authentication.
- All tasks belong to the same shared application.
- There is no separate task detail page.
- There is no API layer.
- There are no automated feature tests in the project.
- Tailwind CSS is loaded from a CDN, so the interface depends on an internet connection for styling.

**11. Useful Commands**

```bash
php artisan route:list
php artisan migrate
php artisan migrate:status
php artisan optimize:clear
php artisan serve --host=0.0.0.0 --port=8000
```

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
