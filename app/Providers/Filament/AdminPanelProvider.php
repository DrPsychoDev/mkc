<?php

namespace App\Providers\Filament;

use App\Filament\Admin\Pages\Welcome;
use App\Http\Middleware\CheckPanelAccess;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Pages\Dashboard;
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

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->sidebarCollapsibleOnDesktop()
            ->collapsedSidebarWidth('9rem')
            ->brandLogo(fn () => view('components.logo-name'))
            ->favicon(asset('images/mkc_logo.png'))
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->profile()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->pages([
//                Pages\Dashboard::class,
                Welcome::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
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
//            ->navigationItems([
//                NavigationItem::make('MKC')
//                    ->url('/')  // Link para home page
//                    ->icon('heroicon-o-link')
//                    ->group('Acessos')
//                    ->sort(1),
//                NavigationItem::make('Área de Presenças')
//                    ->url('/attendance')  // Link para home page
//                    ->icon('heroicon-o-link')
//                    ->group('Acessos')
//                    ->sort(1)
//                    ->visible(fn () => auth()->user()->is_reception),
//                NavigationItem::make('Área de Avaliação')
//                    ->url('/evaluation')  // Link para home page
//                    ->icon('heroicon-o-link')
//                    ->group('Acessos')
//                    ->sort(1)
//                    ->visible(fn () => auth()->user()->is_judge),
//                NavigationItem::make('Dashboard')
//                    ->url('/dashboard')
//                    ->openUrlInNewTab()
//                    ->icon('heroicon-o-presentation-chart-line')
//                    ->visible(fn () => auth()->user()->is_dashboard)
//                    ->sort(1),
//            ]);
    }
}
