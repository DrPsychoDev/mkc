<?php

namespace App\Providers\Filament;

use App\Filament\attendance\Pages\Welcome;
use App\Http\Middleware\CheckPanelAccess;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AttendancePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->sidebarCollapsibleOnDesktop()
            ->collapsedSidebarWidth('9rem')
            ->brandLogo(fn () => view('components.logo-name'))
            ->favicon(asset('images/mkc_logo.png'))
            ->id('attendance')
            ->path('attendance')
            ->login()
            ->profile()
            ->colors([
                'primary' => Color::Pink,
            ])
            ->discoverResources(in: app_path('Filament/Attendance/Resources'), for: 'App\\Filament\\Attendance\\Resources')
            ->discoverPages(in: app_path('Filament/Attendance/Pages'), for: 'App\\Filament\\Attendance\\Pages')
            ->pages([
//                Pages\Dashboard::class,
                Welcome::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Attendance/Widgets'), for: 'App\\Filament\\Attendance\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
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
                CheckPanelAccess::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
