<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FavoriteResource\Pages;
use App\Models\Favourite;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class FavouriteResource extends Resource
{
    protected static ?string $model = Favourite::class;

    protected static ?string $navigationIcon = 'heroicon-s-heart';
    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ??
            __('filament.favourite.plural');
    }

    public static function getNavigationGroup(): string
    {
        return static::$navigationGroup ??
            __('filament.navigation.user_interaction');
    }

    public static function getModelLabel(): string
    {
        return static::$modelLabel ??
            __('filament.favourite.singular');
    }
    public static function getPluralModelLabel(): string
    {
        return static::$pluralModelLabel ??
            __('filament.favourite.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label(__('filament.user.name'))
                    ->relationship('user', 'name')
                    ->default(Auth::id())
                    ->required()
                    ->preload()
                    ->searchable()
                    ->disabled()
                    ->dehydrated(),
                Forms\Components\Select::make('song_id')
                    ->label(__('filament.song.name'))
                    ->relationship('song', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->disabled(fn ($record) => $record && $record->user_id !== Auth::id()),
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('filament.user.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('song.name')
                    ->label(__('filament.song.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament.favourite.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user')
                    ->relationship('user', 'name'),
            ])
            ->actions([
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFavourites::route('/'),
            'create' => Pages\CreateFavourite::route('/create'),
            'edit' => Pages\EditFavourite::route('/{record}/edit'),
        ];
    }
}
