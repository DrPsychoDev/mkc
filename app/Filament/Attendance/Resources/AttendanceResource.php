<?php

namespace App\Filament\Attendance\Resources;

use App\Filament\Attendance\Resources\AttendanceResource\Pages;
use App\Filament\Attendance\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use App\Models\Evaluation;
use App\Models\Participant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class AttendanceResource extends Resource
{
    protected static ?string $model = Participant::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationLabel = 'Presenças';

    protected static ?string $modelLabel = 'Presença';

    protected static ?string $slug = 'presencas';

    public static function getEloquentQuery(): Builder
    {

        return parent::getEloquentQuery()->where('is_present', false);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->grow(false)
                    ->circular()
                    ->label('Foto'),
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
                Tables\Actions\Action::make('Presente')
                    ->size('1rem')
                    ->hiddenLabel()
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->modalHeading(function ($record) {
                        $participantName = $record?->name ?? 'Participante desconhecido';
                        return $participantName;
                    })
                    ->modalDescription("Deseja confirmar a presença?")
                    ->modalIcon('heroicon-o-question-mark-circle')
                    ->modalIconColor('info')
                    ->action(function ($record) {
                        $record->update(['is_present' => true]);
                            Notification::make()
                                ->title("{$record->name} foi marcado como presente")
                                ->icon('heroicon-o-check-circle')
                                ->iconColor('success')
                                ->send();
                    })
                    ->color('success'),
            ]);
//            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
//            ]);
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
            'index' => Pages\ListAttendances::route('/'),
//            'create' => Pages\CreateAttendance::route('/create'),
//            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
