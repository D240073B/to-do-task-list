# To-Do Task List — Walkthrough

## Summary

Built a full-featured **To-Do Task List** web application using **Laravel 9** with **CRUD operations**, **authentication**, and a **premium glassmorphism dark UI**. Data is persisted in the MySQL database `to-do task list` via Laragon/HeidiSQL.

## Setup Steps Completed

| Step | Command | Status |
|---|---|---|
| Create project | `composer create-project laravel/laravel:^9.0 .` | ✅ |
| Configure `.env` | DB_DATABASE=`to-do task list` | ✅ |
| Run migrations | `php artisan migrate` | ✅ |
| Install Laravel UI | `composer require laravel/ui` | ✅ |
| Vue auth scaffolding | `php artisan ui vue --auth` | ✅ |
| npm install | `npm install && npm i vue-loader` | ✅ |
| Fix webpack compat | Pinned `webpack@5.88.0` + added `.vue()` to mix | ✅ |
| npm build | `npm run dev` | ✅ |
| Create Task CRUD | `php artisan make:model Task -mcr` | ✅ |
| Start server | `php artisan serve` → http://localhost:8000 | ✅ |

## Files Created/Modified

### Database
- [2026_04_17_053648_create_tasks_table.php](file:///c:/laragon/www/to-do%20task%20list/database/migrations/2026_04_17_053648_create_tasks_table.php) — Tasks table with `title`, `description`, `status`, `priority`, `due_date`, `user_id`

### Model
- [Task.php](file:///c:/laragon/www/to-do%20task%20list/app/Models/Task.php) — Eloquent model with fillable fields, date casting, and `belongsTo(User)` relationship

### Controller
- [TaskController.php](file:///c:/laragon/www/to-do%20task%20list/app/Http/Controllers/TaskController.php) — Full resource controller with:
  - Auth middleware on all actions
  - Search, status filter, priority filter
  - Pagination (10 per page)
  - Dashboard statistics (total, pending, in_progress, completed)
  - Authorization checks (users can only access their own tasks)

### Routes
- [web.php](file:///c:/laragon/www/to-do%20task%20list/routes/web.php) — Resource route for tasks, redirects `/` and `/home` to `tasks.index`

### Views
- [index.blade.php](file:///c:/laragon/www/to-do%20task%20list/resources/views/tasks/index.blade.php) — Dashboard with stat cards, filters, task table
- [create.blade.php](file:///c:/laragon/www/to-do%20task%20list/resources/views/tasks/create.blade.php) — New task form
- [edit.blade.php](file:///c:/laragon/www/to-do%20task%20list/resources/views/tasks/edit.blade.php) — Edit task form
- [show.blade.php](file:///c:/laragon/www/to-do%20task%20list/resources/views/tasks/show.blade.php) — Task detail view
- [app.blade.php](file:///c:/laragon/www/to-do%20task%20list/resources/views/layouts/app.blade.php) — Layout with Bootstrap 5, glassmorphism nav, flash messages

### Styling
- [custom.css](file:///c:/laragon/www/to-do%20task%20list/public/css/custom.css) — Premium dark theme with glassmorphism, gradient accents, animated stat cards, color-coded badges

## Screenshots

### Task Dashboard (Index)
Shows stat cards (Total: 3, Pending: 1, In Progress: 1, Completed: 1), filter bar, and task table with color-coded status/priority badges:

![Task Dashboard] <img width="2296" height="1183" alt="image" src="https://github.com/user-attachments/assets/a0bbd8dc-b542-4afd-b435-777c14398fef" />


### Task Detail View (Show)
Shows full task details with status, priority, due date, and description:

![Task Detail](C:/Users/yeong/.gemini/antigravity/brain/03049aa8-762e-40d5-8863-7cc641a03fe5/task_detail_view.png)

### Task Edit Form
Pre-filled form for updating task fields:

![Task Edit](C:/Users/yeong/.gemini/antigravity/brain/03049aa8-762e-40d5-8863-7cc641a03fe5/task_edit_form.png)

## Database Verification

Confirmed **3 tasks** and **1 user** are persisted in the `to-do task list` MySQL database:

```json
[
  {"id": 1, "title": "Complete project report", "status": "in_progress", "priority": "high"},
  {"id": 2, "title": "Review team feedback", "status": "in_progress", "priority": "medium"},
  {"id": 3, "title": "Update documentation", "status": "completed", "priority": "low"}
]
```

## How to Run

```bash
# Navigate to project
cd "c:\laragon\www\to-do task list"

# Start Laravel development server
php artisan serve

# Open in browser
# http://localhost:8000
```

> [!TIP]
> Login credentials for testing: `test@example.com` / `password123`
