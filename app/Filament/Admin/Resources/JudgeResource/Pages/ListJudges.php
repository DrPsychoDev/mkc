<?php

namespace App\Filament\Admin\Resources\JudgeResource\Pages;

use App\Exports\JudgesExport;
use App\Filament\Admin\Resources\JudgeResource;
use App\Imports\JudgesImport;
use App\Models\Judge;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListJudges extends ListRecords
{
    protected static string $resource = JudgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('import')
                ->icon('heroicon-o-arrow-down-on-square-stack')
                ->hiddenLabel()
                ->tooltip('Importar registos do excel')
                ->color('info')
                ->action(function (array $data) {
                    // Gera o caminho completo do arquivo
                    $filePath = storage_path('app/public/' . $data['file']);
                    // Verifica se o arquivo existe antes de tentar importar
                    if (!file_exists($filePath)) {
                        throw new \Exception("O arquivo não foi encontrado.");
                    }
                    // Processa o arquivo Excel
                    Excel::import(new JudgesImport, $filePath);
                })
                ->form([
                    FileUpload::make('file')
                        ->label('Arquivo Excel')
                        ->required()
                        ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                        ->directory('temp'), // Define o diretório onde o arquivo será salvo
                ]),
            Actions\Action::make('export')
                ->icon('heroicon-o-arrow-up-on-square-stack')
                ->hiddenLabel()
                ->color('info')
                ->action(function () {
                    $fields = ['id', 'photo','name','school_id','user_id','tatami_id',]; // Campos a serem exportados
                    $fileName = 'juizes-' . now()->format('Y-m-d_H-i-s') . '.xlsx';

                    return Excel::download(new JudgesExport($fields), $fileName);
                }),
            Actions\Action::make('Cria Utilizadores')
                ->icon('heroicon-o-user-plus')
                ->action(function () {
                    Judge::createFilamentUsersFromJudges();
                    Notification::make()
                        ->title('Criação de utilizadores!')
                        ->icon('heroicon-o-user-plus')
                        ->iconColor('success')
                        ->send();
                })
                ->requiresConfirmation()
                ->color('danger'), // Escolha a cor do botão,
            Actions\CreateAction::make(),
        ];
    }
}
