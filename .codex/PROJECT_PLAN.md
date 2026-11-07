# Student Information Management System (SIMS) — Project Plan

## Goal

Build a web-based Student Information Management System that supports user authentication, student records, subjects, enrollments, a dashboard, and selected REST API resources.

## Required features

### Authentication

- User registration
- Login
- Logout
- Authenticated users must have an assigned role.

### Authorization

- Protect application routes from unauthenticated access.
- Provide role-based access control.
- `administrator`: full access.
- `staff`: currently can manage student, subject, and enrollment records; permissions for other administration remain to be defined.
- Administrators can view all registered users and assign either `staff` or `administrator` roles. Public registration always creates Staff accounts; role changes are restricted to administrators, and an administrator cannot demote themselves or the last administrator.

### Student management

- Add a student
- View students
- Edit a student
- Delete a student
- Student fields: student number, first name, last name, email, course, and year level.

### D. Subject Module

Required CRUD operations:

1. Create subject
2. Read/view subjects
3. Update subject
4. Delete subject

Required fields:

- Subject code (stored as `subject_code`; unique)
- Subject name (stored as `name`)
- Units (integer)

An optional description field is also supported.

### E. Enrollment Module

Required CRUD operations:

1. Enroll student
2. View enrollment
3. Update enrollment
4. Delete enrollment

Enrollment records include student, subject, enrollment date, status, and college year level (1–4). The year level is copied from the student's current year level when an existing enrollment is migrated.

Relationships:

- A Student has many Enrollments.
- An Enrollment belongs to one Student and one Subject.
- A Subject has many Enrollments.

### Dashboard

- Show the current counts of students, subjects, and enrollments in a simple, comparable graph.
- Show a vertical enrollment chart grouped by calendar year (from enrollment date) and college year level (1–4).
- Provide the system summary using persisted records.

### REST API

- Required student endpoints:
  - `GET /api/students`
  - `GET /api/students/{id}`
  - `POST /api/students`
  - `PUT /api/students/{id}`
  - `DELETE /api/students/{id}`
- Authenticate API requests with Laravel HTTP Basic authentication using the existing user email and password; send credentials over HTTPS. Both Staff and Administrator roles may use these student endpoints, consistent with web student management.
- Rate-limit API routes to 60 requests per minute per client IP.
- Return a paginated JSON resource for list requests, a single JSON resource for reads/writes, `201` for creation, `200` for read/update, `204` for deletion, `401` for unauthenticated requests, and `422` JSON validation errors.

### F. Validation

Apply server-side validation to every submitted web form and API request:

1. Require all fields needed for each operation; allow only explicitly optional fields to be blank.
2. Validate email fields as valid email addresses.
3. Enforce uniqueness for student numbers, student emails, user emails, subject codes, and student-subject enrollment pairs.
4. Set input length limits that fit the corresponding database columns and mirror them in form controls where practical.
5. Validate numeric ranges, dates, and referenced student/subject IDs.

## Suggested implementation sequence

1. Confirm data fields, relationships, deletion behavior, and user roles needed for the system.
2. Implement authentication and protect management routes.
3. Add student and subject data models, migrations, validation, and CRUD screens.
4. Add enrollment relationships, validation, and CRUD screens.
5. Build dashboard statistics from persisted records.
6. Agree on API resources and access rules, then implement and document the REST endpoints.
7. Verify the required workflows and access controls.

This sequence is a suggested breakdown, not an additional requirement. Update this document when requirements or decisions change.

## Initial database design

The initial migrations establish these assumptions:

- `users`: role defaults to `staff`; application roles are `administrator` and `staff`.
- `students`: unique student number and email; first name, last name, course, and year level.
- `subjects`: unique subject code; name; optional description; units defaulting to 3.
- `enrollments`: foreign keys to student and subject; enrollment date; status defaulting to `enrolled`; required college year level (1–4).
- A student may have only one enrollment per subject at a time, enforced by a unique pair of student and subject IDs.
- Deleting a student or subject cascades to its enrollments.

The initial role value and enrollment uniqueness/deletion behavior are implementation assumptions. Administrator accounts are provisioned by promoting an existing account with the confirmed `php artisan user:make-administrator {email}` command; public registration always creates Staff accounts. Student and enrollment year levels allow college years 1–4. Enrollment management allows one record per student-subject pair as enforced by the schema. Deleting a student or subject cascades to its enrollments. Both Staff and Administrators currently have student, subject, and enrollment CRUD access; permissions for other administration remain open for review.

### User administration updates

- Administrators can view registered user details, update a user's password, and delete users from the Users page.
- Password changes require confirmation and an 8-character minimum. Administrators cannot delete their own account or the last administrator.


### Dashboard statistics

- Student Statistics: show student counts grouped by college year level (1�4).
- Enrollment Statistics: show enrollment counts grouped by status and keep the vertical chart grouped by calendar year and college year level.
- System Summary: show persisted totals for students, subjects, and enrollments.
