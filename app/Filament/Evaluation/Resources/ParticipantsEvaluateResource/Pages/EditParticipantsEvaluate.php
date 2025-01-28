<?php

namespace App\Filament\Evaluation\Resources\ParticipantsEvaluateResource\Pages;

use App\Filament\Evaluation\Resources\ParticipantsEvaluateResource;
use Filament\Resources\Pages\EditRecord;

class EditParticipantsEvaluate extends EditRecord
{
    protected static string $resource = ParticipantsEvaluateResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\DeleteAction::make(),
        ];
    }
}
