<?php

namespace App\Filament\Admin\Resources\SchoolResource\Pages;

use App\Exports\SchoolsExport;
use App\Filament\Admin\Resources\SchoolResource;
use App\Imports\SchoolsImport;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListSchools extends ListRecords
{
    protected static string $resource = SchoolResource::class;

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
                    Excel::import(new SchoolsImport, $filePath);
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
                ->tooltip('Exportar registos para excel')
                ->action(function () {
                    $fields = ['id', 'name',]; // Campos a serem exportados
                    $fileName = 'dojos-' . now()->format('Y-m-d_H-i-s') . '.xlsx';

                    return Excel::download(new SchoolsExport($fields), $fileName);
                }),
            Actions\CreateAction::make(),
        ];
    }
}
