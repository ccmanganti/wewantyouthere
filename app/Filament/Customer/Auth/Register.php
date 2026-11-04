<?php

namespace App\Filament\Customer\Auth;

use Filament\Auth\Pages\Register as BaseRegister;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Register extends BaseRegister
{
    protected function handleRegistration(array $data): Model
    {
        $user = parent::handleRegistration($data);
        $user->assignRole(Role::findOrCreate('User', 'web'));

        return $user;
    }
}
