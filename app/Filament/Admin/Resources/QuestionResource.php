<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Filament\Resources\QuestionResource\RelationManagers;
use App\Models\Question;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationLabel = 'Questões';
    protected static ?string $modelLabel = 'Questão';
    protected static ?string $pluralModelLabel = 'Questões';
    protected static ?string $slug = 'questoes';
    protected static ?string $navigationGroup = 'Gestão';
    protected static ?int $navigationSort = 4;
//    public static function shouldRegisterNavigation(): bool
//    {
        // Verifica se o usuário não é um juiz
//        return !auth()->user()->isJudge();
//    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('identification')
                    ->translateLabel()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('question')
                    ->translateLabel()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('memory')
                    ->translateLabel()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('tatami_id')
                    ->translateLabel()
                    ->relationship('tatami', 'name') // Nome do campo a ser exibido no dropdown
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('division_id')
                    ->translateLabel()
                    ->relationship('division', 'name') // Nome do campo a ser exibido no dropdown
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('identification')
                    ->translateLabel()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('question')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('memory')
                    ->translateLabel()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('tatami.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('division.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->translateLabel()
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->translateLabel()
                    ->dateTime()
                    ->searchable()
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
            'index' => \App\Filament\Admin\Resources\QuestionResource\Pages\ListQuestions::route('/'),
//            'create' => Pages\CreateQuestion::route('/create'),
//            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
