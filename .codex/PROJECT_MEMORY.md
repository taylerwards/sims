# Project memory and change log

This file is the durable, human-readable context for Codex sessions in this repository. `AGENTS.md` instructs Codex to read it before work and append an entry after project changes. Keep entries concise and preserve existing history.

## Project snapshot

- Application: Laravel project named `sims_crud`.
- Framework dependencies: Laravel `^12.0`; PHP `^8.2` (from `composer.json`).
- Current tracked application structure includes the default `User` model, standard Laravel migrations and seeders, a welcome view, and example unit and feature tests.
- SQLite database file exists at `database/database.sqlite`.
- Project-specific Codex agent definitions currently exist under `.codex/agents/` for database, documentation, Laravel development, planning, and testing. Review those files before changing agent setup.
- SIMS feature requirements, authorization roles, validation, student API endpoints, and the suggested delivery sequence are recorded in `.codex/PROJECT_PLAN.md`.
- The Subject Module requirements are Create, Read, Update, and Delete, with subject code, subject name, and units as required fields.
- The Enrollment Module requirements are Enroll, View, Update, and Delete, with Student–Enrollment–Subject relationships.
- Do not store or reproduce credentials, tokens, or values from `.env` here.

## Change history

### 2026-11-06 — Add persistent Codex project memory

- Added this project snapshot and change log so context can carry across Codex sessions.
- Added root `AGENTS.md` instructions to read this file before work and append a dated summary after file changes.
- Validation: inspected the repository structure, `composer.json`, and existing `.codex/agents/` files. No tests were run; this change only adds project documentation and Codex guidance.

### 2026-11-06 — Record SIMS requirements

- Added `.codex/PROJECT_PLAN.md` with the requested authentication, student, subject, enrollment, dashboard, and REST API features.
- Recorded that API resources and contracts remain to be decided, and added a suggested implementation sequence.
- Updated `AGENTS.md` and this memory file to direct future Codex work to the plan.
- Validation: documentation-only change; no tests were run.

### 2026-11-06 — Add initial SIMS database migration

- Added a migration for `students`, `subjects`, and `enrollments`; existing Laravel `users` authentication table remains as provided by the starter migration.
- Assumptions: unique student number and subject code; optional student contacts/demographics; subject units default to 3; enrollment status defaults to `enrolled`; nullable grade; one enrollment per student-subject pair; deleting a student or subject cascades to its enrollments.
- Updated `.codex/PROJECT_PLAN.md` to record the schema and flag these assumptions for confirmation.
- Validation: inspected existing migration conventions. No migration or tests were run.

### 2026-11-06 — Incorporate detailed SIMS requirements

- Updated `.codex/PROJECT_PLAN.md` with protected routes, Administrator and Staff roles, student fields, validation requirements, and the five required student REST endpoints.
- The current students migration includes the required student number, first name, last name, email, course, and year level fields.
- Added a migration for a `users.role` column defaulting to `staff`.
- Open decisions: exact Staff permissions, safe Administrator provisioning, allowed year-level range, API authentication policy, and the enrollment repeat/deletion assumptions.
- Validation: reviewed migration and plan changes; no migrations or tests were run.

### 2026-11-06 — Apply SIMS database migrations

- Ran the pending student, subject, enrollment, and user-role migrations successfully.
- Verified with `php artisan migrate:status`; both SIMS migrations show as `Ran` in batch 2.
- No tests were run.

### 2026-11-06 — Repair database Codex agent configuration

- `.codex/agents/database_agent.toml` now has a valid custom-agent structure with `name`, `description`, and `developer_instructions` fields.
- Its instructions direct the agent to compare schema and migrations with `.codex/PROJECT_PLAN.md` and avoid mutating database commands unless explicitly requested.
- Validation: manually reviewed the TOML structure. Automated TOML parsing was unavailable in the installed Python runtime because it lacks `tomllib`.

### 2026-11-06 — Add initial authentication and dashboard

- Repaired `.codex/agents/laravel_agent.toml` with a valid custom-agent definition before delegating this work.
- Repaired `.codex/agents/testing_agent.toml` with a valid custom-agent definition for QA and verification tasks.
- Added registration, login, and POST logout routes and controllers; registration creates Staff accounts without accepting a role field.
- Added an authenticated empty dashboard and responsive login and registration views.
- Login is rate-limited, successful authentication regenerates the session, and logout invalidates the session and rotates the CSRF token.
- Validation: no tests or build commands were run.

### 2026-11-06 — QA check of authentication pages

- Ran `php artisan test`: the unit example passed; the feature example failed because it still expects `/` to return HTTP 200, while `/` now redirects with HTTP 302 to the protected dashboard.
- PHP syntax checks passed for both authentication controllers and `routes/web.php`; `php artisan route:list` shows the login, registration, logout, and dashboard routes.
- HTTP smoke check returned 200 for GET `/login` and `/register`, and 302 from unauthenticated GET `/dashboard` to `/login`. The temporary server was stopped afterward.
- No POST auth flows were exercised and no tests or application code were changed during this check.

### 2026-11-06 — Repair Laravel agent configuration

- Replaced the malformed `.codex/agents/laravel_agent.toml` with a valid custom-agent definition using `name`, `description`, and `developer_instructions`.
- Instructions now cover Laravel routes, backend/frontend changes, authentication conventions, and project memory updates.
- Validation: reviewed the TOML syntax and required fields; no application tests were run.

### 2026-11-07 — Add student management

- Added authenticated student CRUD screens with search, pagination, required/unique/email validation, and year-level validation (1–8); deleting a student cascades to enrollments under the existing schema.
- Both Staff and Administrator accounts can manage students. Added `user:make-administrator {email}` to promote an existing account after confirmation; public registration remains Staff-only.
- Updated `.codex/PROJECT_PLAN.md` with these decisions and the remaining authorization/enrollment questions.
- Validation: PHP syntax checks passed for the student controller/model, command, and web routes; `route:list` confirmed all six student routes require authentication; the Administrator command safely rejected an unknown email. `php artisan test` had one passing unit test and one pre-existing failing feature test because `/` redirects (302) while the test expects 200. No student CRUD feature tests or end-to-end persistence checks were run.

### 2026-11-07 — Add student details view

- Added a View action to each student table row and an authenticated details page displaying all six student fields, with back and edit links.
- Validation: PHP syntax checks passed for `StudentController.php` and `routes/web.php`; `route:list` confirmed `students.show` is protected by `auth`. `php artisan test` again had one passing starter unit test and one existing failure because the root route redirects (302) while its test expects 200. No authenticated page rendering check was run.

### 2026-11-07 — Add subject and enrollment management

- Added authenticated subject CRUD so users can create subjects for enrollment, plus enrollment create/list/update/delete screens with student/subject selection, duplicate-pair validation, date/status/grade fields, and pagination.
- Both Staff and Administrators currently have access to student, subject, and enrollment CRUD. Subject and student deletion cascade to enrollments under the existing schema.
- Validation: PHP syntax checks passed for the new controllers/models and routes; route listing confirmed subject and enrollment routes require authentication; `php artisan view:cache` passed. `php artisan test` had one passing unit test and the existing failure where `/` returns 302 but its starter feature test expects 200. No authenticated CRUD persistence requests were exercised.

### 2026-11-07 — Record Subject Module requirements

- Recorded the required Subject Module CRUD operations and subject code, subject name, and units fields in `.codex/PROJECT_PLAN.md` and this memory snapshot. Updated the subject form and list labels to use “Subject Code” and “Subject Name.”
- The existing migration and model already support the required fields; no schema change was needed. PHP syntax and Blade view compilation passed, subject routes are authenticated, and `migrate:status` confirms the schema migration ran. `php artisan test` had one passing unit test and one existing failure because `/` returns 302 while the starter test expects 200. No end-to-end subject persistence requests were run.

### 2026-11-07 — Record Enrollment Module requirements

- Recorded Enroll, View, Update, and Delete requirements and the Student–Enrollment–Subject relationships in `.codex/PROJECT_PLAN.md` and this memory snapshot.
- Reviewed the existing implementation: authenticated enrollment create/list/update/delete routes are present; `Student` and `Subject` each have many enrollments, and each `Enrollment` belongs to one student and one subject. No application code or schema changes were needed.
- Validation: manually inspected the models, controller, and routes; no tests were run for this documentation update.

### 2026-11-07 — Replace enrollment grade with year level

- Replaced `grade` with required enrollment `year_level` across the model, validation, form, and list; validation accepts levels 1–8.
- Added and applied a forward migration that backfills each existing enrollment from its student's current year level, then drops the old grade column. Existing grade values are discarded by this change.
- Validation: PHP syntax and Blade compilation passed; all enrollment routes require authentication; `php artisan migrate --force` succeeded, `migrate:status` shows the migration as Ran, and `db:table enrollments` confirms `year_level` exists and `grade` is absent. The test suite had one passing unit test and the existing failure where `/` returns 302 but its starter test expects 200. SQLite isolated migration verification was unavailable because the PHP runtime lacks the SQLite PDO driver; the configured project database migration was applied successfully.

### 2026-11-07 — Set college year-level range

- Changed student and enrollment validation and form limits to college year levels 1–4; updated `.codex/PROJECT_PLAN.md` accordingly. The existing unsigned tiny integer columns already support this range, so no migration was needed.
- Validation: PHP syntax checks and Blade view compilation passed. The unit test passed; the existing starter feature test still fails because `/` returns 302 instead of its expected 200. No CRUD-specific tests exist.

### 2026-11-07 — Add enrollment details route

- Enabled authenticated `GET /enrollments/{enrollment}`, added a View action to each enrollment row, and added a detail page for the student, subject, date, status, and year level.
- Added `tests/Feature/EnrollmentShowRouteTest.php` to check that `/enrollments/2` reaches authentication and redirects guests to login.
- Validation: PHP syntax checks, route listing, and Blade compilation passed; the focused regression test passed. The full suite has two passing tests and the existing failure where `/` returns 302 but `ExampleTest` expects 200. No authenticated details-page rendering test was run.

### 2026-11-07 — Complete validation audit

- Audited registration/login, student create/update/search, subject create/update, and enrollment create/update inputs. Added missing login/password/search/description length limits and aligned form controls; existing required, email, unique, and range/existence rules remain enforced.
- Updated `.codex/PROJECT_PLAN.md` to record required fields, email format checks, unique constraints, length limits, and type/reference validation.
- Validation: PHP syntax checks passed for auth and CRUD controllers; Blade view compilation passed. Unit and enrollment route tests passed; the starter `ExampleTest` still fails because `/` redirects 302 instead of its expected 200. No request-level validation tests were added; database-backed uniqueness validation was not exercised because the test environment lacks an isolated SQLite setup.

### 2026-11-07 — Implement Student API endpoints

- Added the five required `/api/students` endpoints with a paginated `StudentResource`, CRUD validation, JSON responses, HTTP Basic authentication, and a 60 requests/minute throttle. Staff and Administrators may access the endpoints.
- Ensured API authentication runs before route model binding so unauthenticated requests to student IDs return 401 rather than 404. Updated `.codex/PROJECT_PLAN.md` with the API auth and response policy.
- Validation: route listing shows all five endpoints; PHP syntax checks passed; `StudentApiAuthenticationTest` passes all five unauthenticated JSON 401 cases (10 assertions). Full suite has three passing tests and the existing failure where `/` returns 302 instead of the expected 200. Authenticated CRUD and DB-backed validation were not exercised because isolated SQLite testing is unavailable.

### 2026-11-07 — Add dashboard count graph

- Replaced the empty dashboard panel with a responsive horizontal bar graph of current student, subject, and enrollment counts, loaded from the database. The chart uses a shared scale and supports an all-zero dataset without division errors.
- Updated `.codex/PROJECT_PLAN.md` to specify the count graph.
- Validation: dashboard remains behind authentication; PHP syntax and Blade compilation passed, including after aligning scale labels with the bars. The test suite has three passing tests and the existing root-route failure (expected 200, actual 302). No authenticated browser render was performed.

### 2026-11-07 — Add year and year-level dashboard chart

- Kept the student, subject, and enrollment total cards; changed the graph to vertical enrollment bars grouped by calendar year and college year level 1–4. Added a legend, counts, horizontal scrolling for narrow screens, and an empty-data state.
- Used driver-aware SQL year extraction for SQLite, PostgreSQL, and MySQL-compatible databases; updated `.codex/PROJECT_PLAN.md`.
- Validation: PHP syntax and Blade compilation passed; `/dashboard` remains protected by `auth`. Three tests passed; the existing root-route test still fails because `/` returns 302 instead of 200. The automated suite does not execute the dashboard query, so grouped database results were not runtime-tested.

### 2026-11-07 — Group dashboard chart by year and year level

- Added current total cards for students, subjects, and enrollments plus a vertical enrollment chart grouped by calendar year and college year level 1–4.
- Used driver-aware SQL year extraction for SQLite, PostgreSQL, and MySQL-compatible databases; updated `.codex/PROJECT_PLAN.md`.
- Validation: PHP syntax and Blade compilation passed; `/dashboard` remains protected by `auth`. Three tests passed; the existing root-route test still fails (expected 200, actual 302). The automated suite does not execute the grouped dashboard query, so its results were not verified at runtime.

### 2026-11-07 — Add Administrator user and role page

- Added an Administrator-only Users page listing registered users and allowing assignment of the `staff` or `administrator` role. Public registration remains Staff-only; updates block self-demotion and demoting the last Administrator.
- Updated `.codex/PROJECT_PLAN.md` with the user role management policy.
- Validation: PHP syntax, Blade compilation, and route middleware checks passed. The full suite has three passing tests and the existing root-route failure (expected 200, actual 302). No DB-backed user management tests ran because `pdo_sqlite` is unavailable.

### 2026-11-07 � Add user details, deletion, and password update

- Added a registered user details page and Administrator actions to update another user's password and delete a user. Password updates require confirmation and at least eight characters; self-deletion and deleting the last Administrator are blocked.
- Updated the project plan with these user administration capabilities.
- Validation: PHP syntax and Blade compilation passed; named routes require authentication and manage-users. The suite has three passing tests and one existing failure because / returns 302 while the starter test expects 200. DB-backed actions were not exercised because pdo_sqlite is unavailable.


### 2026-11-07 � Rename user details action

- Changed the Users table action label from �View / password� to �Update�; it continues to open the user details and password update page.
- Validation: manually checked the updated Blade label; no tests were run for this text-only change.

### 2026-11-07 � Add subject details view

- Added an authenticated subject details page and a View action in the subjects table. The page displays subject code, name, units, and description, with links back to the list and to edit.
- Validation: controller PHP syntax and Blade compilation passed; the named show route requires authentication. No tests were run.

### 2026-11-07 � Add dashboard statistics and summary

- Added Student Statistics by college year level, Enrollment Statistics by status, and a System Summary of current student, subject, and enrollment totals. Kept the existing enrollment chart grouped by calendar year and year level.
- Updated the project plan with these dashboard requirements.
- Validation: DashboardController PHP syntax and Blade compilation passed. No database-backed dashboard render or tests were run.

### 2026-11-07 � Use ordinal year labels on dashboard

- Changed dashboard year-level labels from �Year 1� through �Year 4� to �First Year� through �Fourth Year� in student statistics, the enrollment chart legend, and chart tooltips.
- Validation: Blade compilation passed; no tests were run.

### 2026-11-07 � Highlight active navigation link

- Added an active style and `aria-current="page"` to the navbar link matching the current route. Resource links stay active on their detail, create, and edit pages.
- Validation: Blade compilation passed; no tests were run.
