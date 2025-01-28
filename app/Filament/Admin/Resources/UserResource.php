<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Resources\UsersResource\Pages;
use App\Filament\Resources\UsersResource\RelationManagers;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ListRecords;



class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Utilizadores';
    protected static ?string $modelLabel = 'Utilizador';
    protected static ?string $pluralModelLabel = 'Utilizadores';
    protected static ?string $slug = 'utilizadores';
    protected static ?string $navigationGroup = 'Sistema';
    protected static ?int $navigationSort = 6;
//    public static function shouldRegisterNavigation(): bool
//    {
        // Verifica se o usuário não é um juiz
//        return !auth()->user()->isJudge();
//    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informações do Utilizador')
                    ->schema([
                        TextInput::make('name')
                            ->label('Utilizador')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('E-mail')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->maxLength(255),

                        TextInput::make('password')
                            ->label('Senha')
                            ->password()
                            ->maxLength(255)
                            ->nullable()
                            ->dehydrateStateUsing(fn ($state) => !empty($state) ? bcrypt($state) : null)
                            ->same('password_confirmation'),

                        TextInput::make('password_confirmation')
                            ->label('Confirme a Senha')
                            ->password()
                            ->maxLength(255)
                            ->nullable()
                            ->dehydrated(false),  // Não armazena este campo no banco de dados
                    ])->columns(2),

                Section::make('Acessos')
                    ->schema([
                        Toggle::make('is_admin')
                            ->label('Administração'),

                        Toggle::make('is_judge')
                            ->label('Avaliação'),

                        Toggle::make('is_reception')
                            ->label('Presenças'),

                        Toggle::make('is_dashboard')
                            ->label('Painéis'),
                    ])->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_admin')
                    ->label('Administração')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_judge')
                    ->label('Avaliação')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_reception')
                    ->label('Presenças')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_dashboard')
                    ->label('Painéis')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => \App\Filament\Admin\Resources\UsersResource\Pages\ListUsers::route('/'),
//            'create' => \App\Filament\Admin\Resources\UsersResource\Pages\CreateUsers::route('/create'),
//            'edit' => \App\Filament\Admin\Resources\UsersResource\Pages\EditUsers::route('/{record}/edit'),
        ];
    }
}
