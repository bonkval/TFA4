# TFA3 project notes

## Request flow

The customer and user list routes use their controllers and models to fetch records. Create and edit forms POST to explicit routes. Controllers trim input and apply CodeIgniter validation rules before inserting or updating through the models. Invalid submissions render the same form with errors and submitted values. Successful submissions redirect to the appropriate listing.

## Validation

| Field | Rules |
| --- | --- |
| Customer full name | Required, at most 100 characters |
| Customer email | Required, valid email, at most 100 characters |
| Customer phone | Optional, at most 20 characters |
| User username | Required, unique among other users, at most 50 characters |
| User full name | Required, at most 100 characters |
| User edit avatar | Optional JPG/PNG image, at most 2 MB |

The user table has a unique database index on `username` as well as the form validation rule.

## Avatar flow

On the edit form, CodeIgniter `getFile('avatar')` retrieves the optional upload. When present, file validation checks that it is an uploaded image, limits the MIME type to JPEG or PNG, and limits its size. The image service decodes and fits it to 256 × 256 pixels. A random filename is used in `public/uploads/avatars/`; only that filename is stored in the nullable `users.avatar` column. The list uses `public/images/avatar-placeholder.svg` when the column is empty. Replacing an avatar removes the previous local file after the database update succeeds.

## Database

`database/tfa3_pos.sql` includes the same five sample customers and users as TFA2, with a nullable `avatar` column on users. For migration-based setup, the original TFA2 migration creates both tables, and `AddAvatarToUsers` adds the column.

## Key files

- `app/Config/Routes.php`: GET and POST routes
- `app/Controllers/Customers.php`, `Users.php`: validation and persistence
- `app/Models/CustomerModel.php`, `UserModel.php`: allowed database fields
- `app/Views/customers/`, `app/Views/users/`: lists and forms
- `app/Database/Migrations/`: schema changes
- `public/images/avatar-placeholder.svg`: fallback avatar

Setup and run instructions are in [README.md](README.md).
