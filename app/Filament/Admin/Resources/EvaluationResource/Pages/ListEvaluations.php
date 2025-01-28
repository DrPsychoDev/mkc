<?php

namespace App\Filament\Admin\Resources\EvaluationResource\Pages;

use App\Exports\EvaluationsExport;
use App\Filament\Admin\Resources\EvaluationResource;
use App\Models\Evaluation;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListEvaluations extends ListRecords
{
    protected static string $resource = EvaluationResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
            Actions\Action::make('export')
                ->icon('heroicon-o-arrow-up-on-square-stack')
                ->hiddenLabel()
                ->color('info')
                ->tooltip('Exportar registos para excel')
                ->action(function () {
                    $fields = ['id', 'participant_id','division_id','question_id','judge_id','evaluation','evaluated_at']; // Campos a seretestetem exportados
                    $fileName = 'avaliacoes-' . now()->format('Y-m-d_H-i-s') . '.xlsx';

                    return Excel::download(new EvaluationsExport($fields), $fileName);
                }),
            Actions\Action::make('Prepara Provas')
                ->icon('heroicon-o-pencil-square')
                ->action(function () {
                    Evaluation::startEvaluations();
                    Notification::make()
                        ->title('Provas disponiveis para avaliação!')
                        ->icon('heroicon-o-document-text')
                        ->iconColor('success')
                        ->send();
                })
                ->requiresConfirmation()
                ->color('danger'), // Escolha a cor do botão,

        ];
    }
}
