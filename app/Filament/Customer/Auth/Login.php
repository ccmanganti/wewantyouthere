<?php

namespace App\Filament\Customer\Auth;

use Filament\Auth\Pages\Login as BaseLogin;

class Login extends BaseLogin
{
    public function getHeading(): string
    {
        return 'Welcome back.';
    }
}
