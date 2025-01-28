<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Resources\ParticipantResource\Pages;
use App\Filament\Resources\ParticipantResource\RelationManagers;
use App\Models\Participant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;

class ParticipantResource extends Resource
{
    protected static ?string $model = Participant::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Participantes';

    protected static ?string $modelLabel = 'Participante';

    protected static ?string $slug = 'participantes';

    protected static ?string $navigationGroup = 'Gestão';

    protected static ?int $navigationSort = 7;
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
                    ->avatar()
                    ->image()
                    ->imageEditor()
                    ->circleCropper()
                    ->directory('participants/photos'),
                Forms\Components\TextInput::make('name')
                    ->columnSpan(3)
                    ->required()
                    ->translateLabel(),
                Forms\Components\DatePicker::make('birthday')
                    ->native(false)
                    ->translateLabel(),
                Forms\Components\Select::make('school_id')
                    ->columnSpan(2)
                    ->translateLabel()
                    ->relationship('school', 'name') // Nome do campo a ser exibido no dropdown
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('division_id')
                    ->columnSpan(2)
                    ->translateLabel()
                    ->relationship('division', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Textarea::make('absence_reason')
                    ->Label('Motivo de Ausência')
                    ->visible('is_present')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('dropout_reason')
                    ->Label('Motivo de Desistência')
                    ->visible('has_dropped_out')
                    ->columnSpanFull(),
            ])->columns(4);
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
                Tables\Columns\TextColumn::make('birthday')
                    ->translateLabel()
                    ->label('Birthday')
                    ->sortable()
                    ->searchable()
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('school.name')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('division.name')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\SelectColumn::make('is_present')
                    ->label('Presença')
                    ->sortable()
                    ->options([
                        '0' => 'Ausente',
                        '1' => 'Presente',
                    ])
                    ->rules(['required']),
                Tables\Columns\SelectColumn::make('has_dropped_out')
                    ->label('Evento')
                    ->sortable()
                    ->options([
                        '0' => 'A competir',
                        '1' => 'Desistiu',
                    ])
                    ->rules(['required']),
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
            'index' => \App\Filament\Admin\Resources\ParticipantResource\Pages\ListParticipants::route('/'),
//            'create' => Pages\CreateParticipant::route('/create'),
//            'edit' => Pages\EditParticipant::route('/{record}/edit'),
        ];
    }


}
