<?php

namespace App\Filament\Resources\BandResource\RelationManagers;

use App\Enums\Role;
use App\Models\User;
use App\Notifications\UserAddedToBand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use function Illuminate\Events\queueable;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return static::$title ?? __('filament.band.band_members');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('id')
                    ->label(__('filament.user.name'))
                    ->relationship('users', 'name', fn ($query) => $query->where('role', '!=', Role::ADMIN))
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
                    ->label(__('filament.actions.attach_group_member'))
                    ->modalHeading(__('filament.actions.attach_group_member'))
                    ->preloadRecordSelect()
                    ->recordSelectOptionsQuery(fn ($query) => $query->where('role', '!=', Role::ADMIN))
                    ->after(function ($data, $livewire) {
                    $user = User::find($data['recordId']);
                    if($user && $user->role !== Role::ADMIN) {
                        $user->update(['role' => Role::GROUP_MEMBER]);
                        $user->notify(new UserAddedToBand($livewire->ownerRecord));
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
