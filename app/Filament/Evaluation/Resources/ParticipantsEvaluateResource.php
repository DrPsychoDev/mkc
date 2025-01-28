<?php

namespace App\Filament\Evaluation\Resources;

use App\Filament\Resources\ParticipantsEvaluateResource\RelationManagers;
use App\Models\Evaluation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ParticipantsEvaluateResource extends Resource
{
    protected static ?string $model = Evaluation::class;
    protected static ?string $navigationLabel = 'Avaliar Participantes';
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $modelLabel = 'Avaliar Participantes';
    protected static ?string $pluralModelLabel = 'Avaliar Participantes';
    protected static ?string $slug = 'avaliar-participantes';

    public static function getEloquentQuery(): Builder
    {
        $currentJudge = Auth::user()->judge?->id; // Obtém o ID do juiz associado ao usuário atual

        return parent::getEloquentQuery()->when($currentJudge, function ($query, $judgeId) {
            $query->where('judge_id', $judgeId)->whereNull('evaluation');
        });
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\View::make('components.participant-photo')
                    ->columnSpanFull()
                    ->label('Fotografia do Participante'),
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
                Tables\Columns\TextColumn::make('division')
                    ->label('Divisão')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('judge.name')
                    ->label('Juiz')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ImageColumn::make('participant.photo')
//                    ->circular()
                    ->label('Foto')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('participant.name')
                    ->label('Participante')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('question.question')
                    ->label('Questão')
                    ->searchable()
                    ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall)
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('participant_id')
                    ->label('Participante')
                    ->multiple()
                    ->preload()
                    ->relationship('participant', 'name'), // Relaciona com o modelo Judge e exibe o nome
                 Tables\Filters\SelectFilter::make('division_id')
                     ->label('Escalão')
                     ->multiple()
                     ->preload()
                     ->relationship('division', 'name') // Relaciona com o modelo Judge e exibe o nome
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('')
                    ->modalHeading('Avaliar Participante')
                    ->modalSubmitActionLabel('Submeter Avaliação') ,
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
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
            'index' => \App\Filament\Evaluation\Resources\ParticipantsEvaluateResource\Pages\ListParticipantsEvaluates::route('/'),
//            'create' => Pages\CreateParticipantsEvaluate::route('/create'),
//            'edit' => Pages\EditParticipantsEvaluate::route('/{record}/edit'),
        ];
    }
}
