<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Resources\SchoolResource\Pages;
use App\Filament\Resources\SchoolResource\RelationManagers;
use App\Models\School;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;

class SchoolResource extends Resource
{
    protected static ?string $model = School::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationLabel = 'Dojos';
    protected static ?string $modelLabel = 'Dojo';
    protected static ?string $pluralModelLabel = 'Dojos';
    protected static ?string $slug = 'dojos';
    protected static ?string $navigationGroup = 'Gestão';
    protected static ?int $navigationSort = 1;
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
                    ->directory('schools/photos'),
                Forms\Components\TextInput::make('name')
                    ->translateLabel()
                    ->required(),
            ])->columns(1);
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
            'index' => \App\Filament\Admin\Resources\SchoolResource\Pages\ListSchools::route('/'),
//            'create' => Pages\CreateSchool::route('/create'),
//            'edit' => Pages\EditSchool::route('/{record}/edit'),
        ];
    }
}
