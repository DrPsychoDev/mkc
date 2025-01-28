<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Resources\EvaluationResource\Pages;
use App\Filament\Resources\EvaluationResource\RelationManagers;
use App\Models\Evaluation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class EvaluationResource extends Resource
{
    protected static ?string $model = Evaluation::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Provas';
    protected static ?string $modelLabel = 'Prova';
    protected static ?string $pluralModelLabel = 'Provas';
    protected static ?string $slug = 'provas';
    protected static ?string $navigationGroup = 'Gestão';
    protected static ?int $navigationSort = 8;

//    public static function shouldRegisterNavigation(): bool
//    {
        // Verifica se o usuário não é um juiz
//        return !auth()->user()->isJudge();
//    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('question_id')
                    ->columnSpanFull()
                    ->translateLabel()
                    ->relationship('question', 'question') // Nome do campo a ser exibido no dropdown
                    ->disabled(),
                Forms\Components\Select::make('participant_id')
                    ->translateLabel()
                    ->relationship('participant', 'name') // Nome do campo a ser exibido no dropdown
                    ->disabled()
                    ->required(),
                Forms\Components\Select::make('judge_id')
                    ->translateLabel()
                    ->relationship('judge', 'name') // Nome do campo a ser exibido no dropdown
                    ->preload()
                    ->required()
                    ->searchable(),
                Forms\Components\Radio::make('evaluation')
                    ->columnSpanFull()
                    ->translateLabel()
                    ->inline()
                    ->options([
                        '0' => '0',
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5'
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('participant.photo')
                    ->circular()
                    ->label('#'),
                Tables\Columns\TextColumn::make('participant.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('question.identification')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('judge.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('evaluation')
                    ->translateLabel()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_evaluations_for_participant')
                    ->label('Avaliação Final')
                    ->sortable() // Permite ordenar
                    ->searchable()
                    ->getStateUsing(fn ($record) => $record->total_evaluations_for_participant),

                Tables\Columns\IconColumn::make('is_evaluation_done')
                    ->label('Concluído')
                    ->sortable()
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                Tables\Actions\BulkAction::make('substituirJuiz')
                    ->label('Substituir Juiz')
                    ->action(function ($records, array $data): void {
                        // Garantir que estamos trabalhando com um array de IDs
                        $recordIds = $records->pluck('id')->toArray();

                        foreach ($recordIds as $recordId) {
                            $evaluation = \App\Models\Evaluation::find($recordId);
                            if ($evaluation) {
                                $evaluation->judge_id = $data['judge_id'];
                                $evaluation->save();
                            }
                        }
                    })
                    ->form([
                        Forms\Components\Select::make('judge_id')
                            ->label('Novo Juiz')
                            ->options(\App\Models\Judge::all()->pluck('name', 'id'))
                            ->required(),
                    ])
                    ->deselectRecordsAfterCompletion(), // Desmarca as linhas


            ])
            ->groups([
                Group::make('participant.name')
                    ->label('')
                    ->collapsible(),
            ])->defaultGroup('participant.name')
            ->groupingSettingsHidden();
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
            'index' => \App\Filament\Admin\Resources\EvaluationResource\Pages\ListEvaluations::route('/'),
            'create' => \App\Filament\Admin\Resources\EvaluationResource\Pages\CreateEvaluation::route('/create'),
//            'edit' => Pages\EditEvaluation::route('/{record}/edit'),
        ];
    }
}
