# Company Management API

A REST API for managing company records with automatic versioning. Built with Laravel 12 using a Domain-Driven Design (DDD) architecture.

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [API Endpoints](#api-endpoints)
  - [Create or Update a Company](#create-or-update-a-company)
  - [Get Company Version History](#get-company-version-history)
- [Deployment](#deployment)
  - [Prerequisites](#prerequisites)
  - [Quick Start](#quick-start)
- [Code Quality](#code-quality)
  - [Git Hooks](#git-hooks)
- [Testing](#testing)
- [Project Structure](#project-structure)

## Features

- Create and update company records identified by EDRPOU (Ukrainian business identifier)
- Automatic versioning — every change to a company record is tracked as a new version
- Version statuses: `Created`, `Updated`, `Duplicate`
- EDRPOU checksum validation

## Tech Stack

- **PHP** 8.4
- **Laravel** 12
- **PostgreSQL** 18
- **Redis** (cache & queues)
- **Laravel Sail** (Docker-based dev environment)

## API Endpoints

All endpoints are prefixed with `/api/v1`.

### Create or Update a Company

```
POST /api/v1/company
```

**Request body:**

| Field     | Type   | Rules                                      |
|-----------|--------|--------------------------------------------|
| `name`    | string | Required, 1–256 characters                 |
| `edrpou`  | string | Required, exactly 8 digits, valid checksum |
| `address` | string | Required, 1–65535 characters               |

**Response:** `200 OK` with the company resource.

If a company with the given EDRPOU already exists, the record is updated and a new version is created.

---

### Get Company Version History

```
GET /api/v1/company/{edrpou}/versions
```

**Response:** `200 OK` with a list of versions for the given EDRPOU.

---

## Deployment

### Prerequisites

- [Docker](https://docs.docker.com/get-docker/) and Docker Compose

### Quick Start

1. **Clone the repository**

   ```bash
   git clone git@github.com:merabuk/laravel-versioning-task.git ueex-test-task
   cd ueex-test-task
   ```

2. **Copy the environment file**

   ```bash
   cp .env.example .env
   ```

3. **Configure the environment**

   Open `.env` and set the following variables for Sail:

   ```dotenv
   APP_URL=http://localhost

   DB_CONNECTION=pgsql
   DB_HOST=pgsql
   DB_PORT=5432
   DB_DATABASE=laravel
   DB_USERNAME=sail
   DB_PASSWORD=password
   ```

4. **Start the Docker containers**

   ```bash
   docker compose up -d
   ```

5. **Install dependencies inside the running container**

    ```bash
   docker compose exec laravel.test composer install --no-interaction
   ```

6. **Generate the application key**

   ```bash
   docker compose exec laravel.test artisan key:generate
   ```

7. **Run database migrations**

   ```bash
   docker compose exec laravel.test artisan migrate
   ```

8. **(Optional) Seed the database**

   ```bash
   docker compose exec laravel.test artisan db:seed
   ```

The API is now available at `http://localhost`.

---

## Code Quality

The project uses three tools for code quality, all available as Composer scripts:

| Command             | Tool                         | Description                                          |
|---------------------|------------------------------|------------------------------------------------------|
| `composer lint`     | ECS (Easy Coding Standard)   | Check code style (PSR-12, clean code, Laravel rules) |
| `composer lint:fix` | ECS                          | Check and auto-fix code style violations             |
| `composer phpstan`  | PHPStan (level 8) + Larastan | Static analysis                                      |
| `composer analyze`  | ECS + PHPStan                | Run both checks in sequence                          |

Run any of them via Docker:

```bash
docker compose exec laravel.test composer lint
docker compose exec laravel.test composer lint:fix
docker compose exec laravel.test composer phpstan
docker compose exec laravel.test composer analyze
```

### Git Hooks

[GrumPHP](https://github.com/phpro/grumphp) enforces code quality on every commit by automatically running ECS, PHPStan, `composer validate`, YAML lint, and a blacklist check (blocks `dd()`, `dump()`, `die`, etc.).

Initialize the git hooks after installing dependencies:

```bash
docker compose exec laravel.test php vendor/bin/grumphp git:init
```

From this point, every `git commit` will trigger all checks inside the Docker container. The commit is blocked if any check fails.

For running all checks manually
```bash
docker compose exec laravel.test php vendor/bin/grumphp run
```
---

## Testing

Run the full test suite:

```bash
docker compose exec laravel.test php artisan test
```

Tests use a dedicated `testing` PostgreSQL database (automatically created by Sail on first start).

---

## Project Structure

```
app/
├── App/Api/V1/          # Controllers, Form Requests, API Resources, Routes
├── Core/Versioning/     # Polymorphic versioning system (Model, Service, Trait)
├── Domain/Company/      # Company domain (Model, Actions, Service, DTO, Migrations)
└── Infrastructure/      # Exception handling, HTTP utilities

database/
├── migrations/          # Core Laravel migrations
└── seeders/             # DatabaseSeeder → CompanySeeder

tests/
├── Feature/             # API endpoint tests
└── Unit/                # Business logic and validator tests
```
