<?php

namespace App\Filament\Admin\Widgets;

use Filament\Forms\Components\Actions\Action;
use Filament\Widgets\Widget;

class MenusOverview extends Widget
{
    protected static string $view = 'filament.admin.widgets.menus-overview';
    protected int | string | array $columnSpan = 'full';

}
