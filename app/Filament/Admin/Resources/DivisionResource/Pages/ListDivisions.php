<?php

namespace App\Filament\Admin\Resources\DivisionResource\Pages;

use App\Exports\DivisionsExport;
use App\Filament\Admin\Resources\DivisionResource;
use App\Imports\DivisionsImport;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListDivisions extends ListRecords
{
    protected static string $resource = DivisionResource::class;

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
                    Excel::import(new DivisionsImport, $filePath);
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
                    $fields = ['id', 'name']; // Campos a serem exportados
                    $fileName = 'escaloes-' . now()->format('Y-m-d_H-i-s') . '.xlsx';
                    return Excel::download(new DivisionsExport($fields), $fileName);
                }),
//            ImportAction::make()
//                ->importer(DivisionImporter::class),
//            ExportAction::make()
//                ->exporter(DivisionExporter::class),
            Actions\CreateAction::make(),

        ];
    }
}
