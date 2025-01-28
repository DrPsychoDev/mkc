<?php

namespace App\Filament\Admin\Resources\TatamiResource\Pages;

use App\Filament\Admin\Resources\TatamiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTatami extends EditRecord
{
    protected static string $resource = TatamiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
