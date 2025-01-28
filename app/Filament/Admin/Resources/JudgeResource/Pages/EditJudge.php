<?php

namespace App\Filament\Admin\Resources\JudgeResource\Pages;

use App\Filament\Admin\Resources\JudgeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJudge extends EditRecord
{
    protected static string $resource = JudgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
