<?php

namespace App\Filament\Customer\Pages;

use Filament\Pages\Page;

class Billing extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationLabel = 'Plan & Billing';

    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.customer.pages.billing';

    public function getTitle(): string
    {
        return 'Plan & Billing';
    }
}
