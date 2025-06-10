<?php

namespace App\Filament\Resources\InstrumentResource\RelationManagers;

use App\Models\User;
use App\Notifications\InstrumentAttached;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return static::$title ?? __('filament.instrument.musicians');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('id')
                    ->label(__('filament.instrument.musician'))
                    ->options(User::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament.user.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('filament.user.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->label(__('filament.user.role'))
                    ->badge()
                    ->color(fn ($record) => $record->role->getColor()),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label(__('filament.actions.attach_musician'))
                    ->modalHeading(__('filament.actions.attach_musician'))
                    ->preloadRecordSelect()
                    ->after(function ($data, $livewire) {
                        $user = User::find($data['recordId']);
                        if ($user) {
                            $user->notify(new InstrumentAttached($livewire->ownerRecord));
                        }
            }),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
