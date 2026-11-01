<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class AssignInitialSuperadminSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $user = User::where('email', 'rsvp@wewantyouthere.com')->first();

        if (! $user) {
            throw new RuntimeException('Create rsvp@wewantyouthere.com first using php artisan make:filament-user.');
        }

        $user->assignRole('Superadmin');
        $user->forceFill(['email_verified_at' => $user->email_verified_at ?? now()])->save();
    }
}
