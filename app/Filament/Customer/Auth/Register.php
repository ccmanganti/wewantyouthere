<?php

namespace App\Filament\Customer\Auth;

use Filament\Auth\Pages\Register as BaseRegister;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Register extends BaseRegister
{
    public function getHeading(): string | \Illuminate\Contracts\Support\Htmlable | null
    {
        return session()->has('pending_wedding')
            ? 'Create your account to publish'
            : 'Create your free account';
    }

    protected function handleRegistration(array $data): Model
    {
        $user = parent::handleRegistration($data);
        $user->assignRole(Role::findOrCreate('User', 'web'));

        return $user;
    }
}
