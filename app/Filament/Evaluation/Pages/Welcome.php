<?php

namespace App\Filament\Evaluation\Pages;

use App\Filament\Admin\Widgets\EvaluationsOverview;
use App\Filament\Admin\Widgets\MenusOverview;
use Filament\Pages\Page;

class Welcome extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    protected static ?string $navigationLabel = 'MKC Avaliação';
    protected static ?string $title = 'MKC Avaliação';

    protected static string $view = 'filament.evaluation.pages.welcome';

    protected function getHeaderWidgets(): array
    {
        return [
            MenusOverview::class,
            EvaluationsOverview::class,

        ];
    }
}
