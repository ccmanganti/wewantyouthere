<?php

namespace App\Filament\Customer\Widgets;

use Filament\Widgets\Widget;

class WelcomeWidget extends Widget
{
    protected string $view = 'filament.customer.widgets.welcome';

    protected int | string | array $columnSpan = 'full';

    protected static bool $isLazy = false;
}
