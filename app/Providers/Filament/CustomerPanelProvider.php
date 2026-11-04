<?php

namespace App\Providers\Filament;

use App\Filament\Customer\Auth\Register as CustomerRegister;
use App\Http\Middleware\CompletePendingWeddingAfterSignIn;
use App\Filament\Customer\Pages\Billing;
use App\Filament\Customer\Widgets\WelcomeWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class CustomerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('app')
            ->path('app')
            ->brandName('we want you there.')
            ->login()
            ->registration(CustomerRegister::class)
            ->passwordReset()
            ->profile(isSimple: false)
            ->colors([
                'primary' => Color::hex('#810100'),
            ])
            ->darkMode(false)
            ->spa()
            ->unsavedChangesAlerts()
            ->discoverResources(in: app_path('Filament/Customer/Resources'), for: 'App\\Filament\\Customer\\Resources')
            ->pages([
                Dashboard::class,
                Billing::class,
            ])
            ->widgets([
                WelcomeWidget::class,
            ])
            ->renderHook(PanelsRenderHook::HEAD_END, fn () => view('filament.customer.brand'))
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                CompletePendingWeddingAfterSignIn::class,
            ]);
    }
}
