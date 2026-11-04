<?php

namespace App\Providers\Filament;

use App\Filament\Customer\Auth\Register as CustomerRegister;
use App\Filament\Customer\Auth\Login as CustomerLogin;
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
            ->brandName('We Want You There')
            ->brandLogo(fn () => view('filament.customer.navigation.brand-logo'))
            ->brandLogoHeight('2.7rem')
            ->favicon(asset('brand/wwyt/favicon.png'))
            ->login(CustomerLogin::class)
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
            ->renderHook(PanelsRenderHook::SIMPLE_LAYOUT_START, fn () => view('filament.customer.auth.navigation'))
            ->renderHook(PanelsRenderHook::TOPBAR_LOGO_AFTER, fn () => view('filament.customer.navigation.topbar'))
            ->renderHook(PanelsRenderHook::SIDEBAR_FOOTER, fn () => view('filament.customer.navigation.sidebar-footer'))
            ->renderHook(PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, fn () => view('filament.customer.auth.google-button'))
            ->renderHook(PanelsRenderHook::AUTH_REGISTER_FORM_BEFORE, fn () => view('filament.customer.auth.google-button'))
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
