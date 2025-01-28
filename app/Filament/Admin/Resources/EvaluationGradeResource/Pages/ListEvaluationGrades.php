<?php

namespace App\Filament\Admin\Resources\EvaluationGradeResource\Pages;

use App\Filament\Admin\Resources\EvaluationGradeResource;
use Filament\Resources\Pages\ListRecords;

class ListEvaluationGrades extends ListRecords
{
    protected static string $resource = EvaluationGradeResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
