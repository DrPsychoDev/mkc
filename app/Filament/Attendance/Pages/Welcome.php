<?php

namespace App\Filament\Attendance\Pages;

use App\Filament\Admin\Widgets\EvaluationsOverview;
use App\Filament\Admin\Widgets\MenusOverview;
use Filament\Pages\Page;

class Welcome extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    protected static ?string $navigationLabel = 'MKC Presenças';
    protected static ?string $title = 'MKC Presenças';

    protected static string $view = 'filament.attendance.pages.welcome';

    protected function getHeaderWidgets(): array
    {
        return [
            MenusOverview::class,
            EvaluationsOverview::class,

        ];
    }
}
