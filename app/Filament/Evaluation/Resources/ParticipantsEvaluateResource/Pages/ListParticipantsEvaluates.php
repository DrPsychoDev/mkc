<?php

namespace App\Filament\Evaluation\Resources\ParticipantsEvaluateResource\Pages;

use App\Filament\Evaluation\Resources\ParticipantsEvaluateResource;
use Filament\Resources\Pages\ListRecords;

class ListParticipantsEvaluates extends ListRecords
{
    protected static string $resource = ParticipantsEvaluateResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),

        ];
    }
}
