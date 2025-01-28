<?php

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Widgets\EvaluationsOverview;
use App\Filament\Admin\Widgets\MenusOverview;
use Filament\Facades\Filament;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets;

class Welcome extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    protected static ?string $navigationLabel = 'MKC Administrador';
    protected static ?string $title = 'MKC Administrador';


    protected static string $view = 'filament.admin.pages.welcome';


    protected function getHeaderWidgets(): array
    {
        return [
            MenusOverview::class,
            EvaluationsOverview::class,

        ];
    }

}
