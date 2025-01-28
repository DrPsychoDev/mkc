<?php

namespace App\Filament\Admin\Resources\EvaluationGradeResource\Pages;

use App\Filament\Admin\Resources\EvaluationGradeResource;
use Filament\Resources\Pages\EditRecord;

class EditEvaluationGrade extends EditRecord
{
    protected static string $resource = EvaluationGradeResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\DeleteAction::make(),
        ];
    }
}
