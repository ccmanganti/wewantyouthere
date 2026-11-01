<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class DevelopmentSuperadminSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment('local', 'testing')) {
            throw new RuntimeException('Development superadmin seeder may only run locally or in tests.');
        }

        $email = env('DEV_SUPERADMIN_EMAIL', 'superadmin@wewantyouthere.com');
        $password = env('DEV_SUPERADMIN_PASSWORD');

        if (! $password) {
            throw new RuntimeException('Set DEV_SUPERADMIN_PASSWORD in .env first.');
        }

        User::updateOrCreate(
            ['email' => $email],
            ['name' => 'Super Administrator', 'password' => Hash::make($password), 'email_verified_at' => now()]
        );
    }
}
