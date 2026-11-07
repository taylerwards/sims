# Student Information Management System (SIMS)

SIMS is a Laravel 12 application for managing college students, subjects, enrollments, user roles, and dashboard statistics. It also provides an authenticated JSON API for student records.

## Live website and hosting

- **Login:** [https://sims.wltech.dev/login](https://sims.wltech.dev/login)

Sample Accounts:

Admin Account:
Email:admin@gmail.com
Password:admin1234
User Account:
Email:user1@gmail.com
Password:user1234

use the same login credential in API login form.

- **GitHub repository:** [taylerwards/sims](https://github.com/taylerwards/sims)
- **Hosting provider:** Hostinger
- **Source and deployment:** The project is connected to GitHub and uses a CI/CD deployment workflow for the hosted site.
- **Production database:** MySQL

The live application requires an account to sign in. Public registration creates Staff accounts.

## Features

- Student records: create, view, update, and delete. Each student has a student number, name, email, course, and college year level (1–4).
- Subject management: create, view, update, and delete subjects with a unique subject code, name, units, and optional description.
- Enrollment management: create, view, update, and delete student-subject enrollments with enrollment date, status, and college year level.
- Dashboard: student statistics by year level, enrollment statistics by status, an enrollment chart by calendar year and year level, and current system totals.
- Authentication: registration, login, and logout. Staff and Administrators can manage student, subject, and enrollment records.
- Administrator user management: view accounts, assign Staff or Administrator roles, update passwords, and delete accounts. Administrators cannot demote or delete themselves or remove the last Administrator.

## Requirements

- PHP 8.2 or later with Laravel's required PHP extensions, including `pdo_mysql` for MySQL.
- Composer.
- MySQL for the production database. For local development, configure MySQL in `.env` as well.
- Node.js and npm if you need to rebuild frontend assets.

## Local setup

1. Install PHP dependencies and create a local environment file:

    ```sh
    composer install
    cp .env.example .env
    ```

    On Windows PowerShell, use `Copy-Item .env.example .env` instead of `cp` if needed.

2. Configure the local database in `.env`. Use the MySQL database name, username, and password from your local MySQL setup. Do not commit `.env` or share its credentials. The relevant settings are:

    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_mysql_username
    DB_PASSWORD=your_mysql_password
    ```

3. Generate the app key and run migrations:

    ```sh
    php artisan key:generate
    php artisan migrate
    ```

4. If you need to rebuild frontend assets, install and build them:

    ```sh
    npm install
    npm run build
    ```

5. Start Laravel's local development server:

    ```sh
    php artisan serve
    ```

    Open the local address printed by Artisan and register an account. New registrations receive the Staff role.

### Provision the first Administrator

After registering the account that should administer the system, run this command from the project directory:

```sh
php artisan user:make-administrator person@example.com
```

The command asks for confirmation and promotes an existing account; it does not create one.

## Deployment

The production website is hosted on Hostinger and connected to the GitHub repository through CI/CD. Configure the production environment in Hostinger with the MySQL connection details, application key, and other required Laravel environment settings. Keep database credentials and `APP_KEY` in the hosting environment; never put them in this repository. Serve the site over HTTPS, especially because the API uses HTTP Basic Authentication.

## Student API

The student API is available under `/api/students`. It uses HTTP Basic Authentication with an existing SIMS account's email address as the username and its password. Staff and Administrators can use the API. All API routes are limited to 60 requests per minute per client IP. Use HTTPS when sending credentials.

| Method   | Endpoint             | Purpose                     |
| -------- | -------------------- | --------------------------- |
| `GET`    | `/api/students`      | List students (15 per page) |
| `GET`    | `/api/students/{id}` | Read one student            |
| `POST`   | `/api/students`      | Create a student            |
| `PUT`    | `/api/students/{id}` | Update a student            |
| `DELETE` | `/api/students/{id}` | Delete a student            |

Example request. `curl` prompts for the password instead of including it in the command:

```sh
curl --user "person@example.com" \
  -H "Accept: application/json" \
  https://sims.wltech.dev/api/students
```

Create and update requests accept JSON with all of these required fields:

```json
{
    "student_number": "S-1001",
    "first_name": "Alex",
    "last_name": "Rivera",
    "email": "alex@example.com",
    "course": "Information Technology",
    "year_level": 1
}
```

Email must be valid; student number and email must be unique; year level must be an integer from 1 through 4. Validation errors return `422` JSON. Successful creates return `201`, reads and updates return `200`, deletes return `204`, and unauthenticated requests return `401`. List responses include Laravel pagination metadata.

## Tests

Run the automated test suite with:

```sh
php artisan test
```
