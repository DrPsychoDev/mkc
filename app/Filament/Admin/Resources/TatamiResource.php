<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Resources\TatamiResource\Pages;
use App\Filament\Resources\TatamiResource\RelationManagers;
use App\Models\Tatami;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;

class TatamiResource extends Resource
{
    protected static ?string $model = Tatami::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $navigationLabel = 'Tatamis';
    protected static ?string $modelLabel = 'Tatami';
    protected static ?string $pluralModelLabel = 'Tatamis';
    protected static ?string $slug = 'tatamis';
    protected static ?string $navigationGroup = 'Gestão';
    protected static ?int $navigationSort = 3;
//    public static function shouldRegisterNavigation(): bool
//    {
        // Verifica se o usuário não é um juiz
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
                    ->image()
                    ->imageEditor()
                    ->directory('tatamis/photos'),
                Forms\Components\TextInput::make('name')
                    ->translateLabel()
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->translateLabel()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->circular()
                    ->label('Logo'),
                Tables\Columns\TextColumn::make('name')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->translateLabel()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => \App\Filament\Admin\Resources\TatamiResource\Pages\ListTatamis::route('/'),
//            'create' => Pages\CreateTatami::route('/create'),
//            'edit' => Pages\EditTatami::route('/{record}/edit'),
        ];
    }
}
