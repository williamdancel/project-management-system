# PMS API (Laravel 12)

Project Management System API built with **Laravel 12**, **Sanctum**, **API versioning**, **role-based access**, **service classes**, **FormRequests**, and **seeded demo data**.

## Requirements
- PHP 8.2+
- Composer
- SQLite (default) or any supported DB

## Setup

1) Install dependencies
```bash
composer install
```

2) Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

3) Run migrations
```bash
php artisan migrate
```

4) Seed demo data (3 admins, 3 managers, 5 users, 5 projects, 10 tasks, 10 comments)
```bash
php artisan db:seed
```

5) Run the app
```bash
php artisan serve
```

## API Versioning
API routes are prefixed using `API_VERSION` from `.env`.

Example:
- `API_VERSION=v1`
- Base prefix becomes: `/api/v1`

## Authentication
Uses **Laravel Sanctum** (Bearer token).

Send token via header:
```
Authorization: Bearer <token>
```

## Roles
- **admin**: Projects CRUD (create/update/delete)
- **manager**: Create/Delete Tasks under a Project
- **user**: Can update assigned tasks (policy) and add/view comments (based on your access rules)

## Endpoints (v1)

### Auth
- `POST /api/v1/register`
- `POST /api/v1/login`
- `POST /api/v1/logout` *(auth required)*
- `GET  /api/v1/me` *(auth required)*

### Projects
- `GET    /api/v1/projects` *(auth required)*
- `GET    /api/v1/projects/{id}` *(auth required)*
- `POST   /api/v1/projects` *(admin only)*
- `PUT    /api/v1/projects/{id}` *(admin only)*
- `DELETE /api/v1/projects/{id}` *(admin only)*

### Tasks
- `GET    /api/v1/projects/{project_id}/tasks` *(auth required)*
- `GET    /api/v1/tasks/{id}` *(auth required)*
- `POST   /api/v1/projects/{project_id}/tasks` *(manager only)*
- `PUT    /api/v1/tasks/{id}` *(manager OR assigned user only - policy)*
- `DELETE /api/v1/tasks/{id}` *(manager only)*

### Comments
- `GET  /api/v1/tasks/{task_id}/comments` *(auth required)*
- `POST /api/v1/tasks/{task_id}/comments` *(auth required)*

### AppServiceProvider
- Added automaticallyEagerLoadRelationships Method to eager load all of the queries across the application.

## Postman
Import the Postman collection JSON file:
- `PMS API v1.postman_collection`

Set collection variables:
- `base_url` (default: `http://127.0.0.1:8000`)
- `token` (paste token from login response)
- `project_id`, `task_id` (set from API responses)

## Seeded Accounts
All seeded users have password:
- `Userpass@pmslocal`

## Testing
Run automated tests:
```bash
php artisan test
```
