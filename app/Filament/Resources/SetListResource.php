<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SetListResource\Pages;
use App\Filament\Resources\SetListResource\RelationManagers\SongsRelationManager;
use App\Models\SetList;
use App\Notifications\SetlistPublished;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;

class SetListResource extends Resource
{
    protected static ?string $model = SetList::class;

    protected static ?string $navigationIcon = 'heroicon-s-list-bullet';
    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ??
            __('filament.set_list.plural');
    }

    public static function getNavigationGroup(): string
    {
        return static::$navigationGroup ??
            __('filament.navigation.band_management');
    }

    public static function getModelLabel(): string
    {
        return static::$modelLabel ??
            __('filament.set_list.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return static::$pluralModelLabel ??
            __('filament.set_list.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('filament.set_list.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('band_id')
                    ->label(__('filament.band.name'))
                    ->relationship('band', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\DatePicker::make('performed_at')
                    ->label(__('filament.set_list.performed_at'))
                    ->required(),
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament.set_list.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('band.name')
                    ->label(__('filament.band.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('performed_at')
                    ->label(__('filament.set_list.performed_at'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('songs_count')
                    ->label(__('filament.set_list.songs_count'))
                    ->counts('songs')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('band')
                    ->relationship('band', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            SongsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSetLists::route('/'),
            'create' => Pages\CreateSetList::route('/create'),
            'edit' => Pages\EditSetList::route('/{record}/edit'),
        ];
    }
}
