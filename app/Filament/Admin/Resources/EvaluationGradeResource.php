<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Resources\EvaluationGradeResource\Pages;
use App\Filament\Resources\EvaluationGradeResource\RelationManagers;
use App\Models\Participant;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EvaluationGradeResource extends Resource
{
    protected static ?string $model = Participant::class;
    protected static ?string $navigationIcon = 'heroicon-o-trophy';
    protected static ?string $navigationLabel = 'Avaliações';
    protected static ?string $modelLabel = 'Avaliação';
    protected static ?string $pluralModelLabel = 'Avaliações';
    protected static ?string $slug = 'avaliacoes';
//    protected static ?string $navigationGroup = 'Gestão';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Participante')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_evaluation')
                    ->label('Nota Final')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->icon(fn (string $state): string => match ($state) {
                        '0' => 'heroicon-o-clock',
                        '1' => 'heroicon-o-pencil-square',
                        '2' => 'heroicon-o-check-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        '0' => 'info',
                        '1' => 'warning',
                        '2' => 'success',
                        default => 'gray',
                    })
            ])
            ->filters([
                //
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Admin\Resources\EvaluationGradeResource\Pages\ListEvaluationGrades::route('/'),
//            'create' => Pages\CreateEvaluationGrade::route('/create'),
//            'edit' => Pages\EditEvaluationGrade::route('/{record}/edit'),
        ];
    }
}
