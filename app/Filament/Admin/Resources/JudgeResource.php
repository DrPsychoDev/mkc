<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Resources\JudgeResource\Pages;
use App\Filament\Resources\JudgeResource\RelationManagers;
use App\Models\Judge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;

class JudgeResource extends Resource
{
    protected static ?string $model = Judge::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Juízes';
    protected static ?string $modelLabel = 'Juíz';
    protected static ?string $pluralModelLabel = 'Juízes';
    protected static ?string $slug = 'juizes';
    protected static ?string $navigationGroup = 'Gestão';
    protected static ?int $navigationSort = 5;
//    public static function shouldRegisterNavigation(): bool
//    {
//         Verifica se o usuário não é um juiz
//        return !auth()->user()->isJudge();
//    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('photo')
                    ->columnSpanFull()
                    ->alignment(Alignment::Center)
                    ->translateLabel()
                    ->avatar()
                    ->image()
                    ->imageEditor()
                    ->circleCropper()
                    ->directory('judges/photos'),
                Forms\Components\TextInput::make('name')
                    ->translateLabel()
                    ->required(),
                Forms\Components\Select::make('school_id')
                    ->translateLabel()
                    ->relationship('school', 'name') // Nome do campo a ser exibido no dropdown
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->translateLabel(),
                Forms\Components\TextInput::make('password')
                    ->translateLabel()
                    ->password()
                    ->revealable(),
                Forms\Components\Select::make('user_id')
                    ->translateLabel()
                    ->relationship('user', 'name') // Nome do campo a ser exibido no dropdown
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('tatami_id')
                    ->translateLabel()
                    ->relationship('tatami', 'name') // Nome do campo a ser exibido no dropdown
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('divisions')
                    ->columnSpanFull()
                    ->multiple() // Habilita a seleção múltipla
                    ->preload()
                    ->relationship('divisions', 'name') // Mostra o nome das divisões relacionadas ao juiz
                    ->label('Divisões que o juiz trata'),
                Forms\Components\Toggle::make('is_substitute')
                    ->label('Juiz Suplente'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->circular()
                    ->label('#'),
                Tables\Columns\TextColumn::make('name')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('divisions.name')
                    ->label('Escalões')
                    ->badge()
                    ->wrap() // Opcional: quebra linhas para divisões longas
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('school.name')
                    ->translateLabel()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user.name')
                    ->translateLabel()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('access')
                    ->label('Acesso')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tatami.name')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_substitute')
                    ->label('Juiz Suplente')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->searchable()
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
            'index' => \App\Filament\Admin\Resources\JudgeResource\Pages\ListJudges::route('/'),
//            'create' => Pages\CreateJudge::route('/create'),
//            'edit' => Pages\EditJudge::route('/{record}/edit'),
        ];
    }
}
