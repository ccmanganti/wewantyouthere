# We Want You There - Development

Laravel 12, Filament v5, PHP 8.4 and MySQL.

1. Run `composer install` and `npm install`.
2. Copy `.env.example` to `.env` and configure your local MySQL database.
3. Run `php artisan key:generate`.
4. Run `php artisan migrate`.
5. Run `php artisan db:seed --class=DevelopmentSuperadminSeeder`.
6. Run `composer run dev`.

Filament admin panel: `/admin`.

Development-only account: `superadmin@wewantyouthere.com`. The example environment password is `password`; replace it before sharing any environment. The seeder refuses to run in production. The account is a seeded user; Filament panel authorization and explicit superadmin roles must be implemented before production use. Never commit `.env`.
