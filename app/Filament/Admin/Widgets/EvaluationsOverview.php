<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Division;
use App\Models\Evaluation;
use App\Models\Participant;
use App\Models\Tatami;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EvaluationsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';
    protected function getHeading(): ?string
    {
        return 'Informação do Evento';
    }

    protected function getDescription(): ?string
    {
        return 'Alguma informaçãp para análise.';
    }
    protected function getStats(): array
    {
        $divisions = Division::all();
        $tatamis = Tatami::all();


        $stats = [];

        foreach ($divisions as $division) {
            $total = Evaluation::where('division_id', $division->id)->count();
            $completed = Evaluation::where('division_id', $division->id)->whereNotNull('evaluation')->count();

            $percentage = $total > 0 ? ($completed / $total) * 100 : 0;
            $percentageFormatted = number_format($percentage, 0);

            $color = match (true) {
                $percentageFormatted == 0 => 'danger',       // Vermelho
                $percentageFormatted >= 50 && $percentageFormatted < 100 => 'warning', // Amarelo
                $percentageFormatted == 100 => 'success',    // Verde
                default => 'primary',                        // Cor padrão (se necessário)
            };

            $stats[] = Stat::make($division->name, number_format($percentage, 0) . '%')
                ->description("Total: $total, Concluídas: $completed")
                ->icon('heroicon-o-swatch')
                ->color($color);


            foreach ($tatamis as $tatami) {
                $total = Evaluation::where('division_id', $division->id)->where('tatami_id', $tatami->id)->count();
                $completed = Evaluation::where('division_id', $division->id)->where('tatami_id', $tatami->id)->whereNotNull('evaluation')->count();

                $percentage = $total > 0 ? ($completed / $total) * 100 : 0;
                $percentageFormatted = number_format($percentage, 0);

                $color = match (true) {
                    $percentageFormatted == 0 => 'danger',       // Vermelho
                    $percentageFormatted >= 50 && $percentageFormatted < 100 => 'warning', // Amarelo
                    $percentageFormatted == 100 => 'success',    // Verde
                    default => 'primary',                        // Cor padrão (se necessário)
                };

                $stats[] = Stat::make($tatami->name, number_format($percentage, 0) . '%')
                    ->description("Total: $total, Concluídas: $completed")
                    ->icon('heroicon-o-rectangle-group')
                    ->color($color);
            }

        }



        return $stats;

//
//        return [
//            Stat::make('Unique views', '192.1k')
//                ->description('32k increase')
//                ->descriptionIcon('heroicon-m-arrow-trending-up')
//                ->chart([7, 2, 10, 3, 15, 4, 17])
//                ->color('success'),
//            Stat::make('Bounce rate', '21%')
//                ->description('7% increase')
//                ->descriptionIcon('heroicon-m-arrow-trending-down')
//                ->color('danger'),
//            Stat::make('Average time on page', '3:12')
//                ->description('3% increase')
//                ->descriptionIcon('heroicon-m-arrow-trending-up')
//                ->color('success'),
//        ];
    }
}
