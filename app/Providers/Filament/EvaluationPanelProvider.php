<?php

namespace App\Providers\Filament;

use App\Filament\Evaluation\Pages\Welcome;
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

class EvaluationPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->sidebarCollapsibleOnDesktop()
            ->collapsedSidebarWidth('9rem')
            ->brandLogo(fn () => view('components.logo-name'))
            ->favicon(asset('images/mkc_logo.png'))
            ->id('evaluation')
            ->path('evaluation')
            ->login()
            ->profile()
            ->colors([
                'primary' => Color::Green,
            ])
            ->discoverResources(in: app_path('Filament/Evaluation/Resources'), for: 'App\\Filament\\Evaluation\\Resources')
            ->discoverPages(in: app_path('Filament/Evaluation/Pages'), for: 'App\\Filament\\Evaluation\\Pages')
            ->pages([
//                Pages\Dashboard::class,
                Welcome::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Evaluation/Widgets'), for: 'App\\Filament\\Evaluation\\Widgets')
            ->widgets([
//                Widgets\AccountWidget::class,
//                Widgets\FilamentInfoWidget::class,
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
