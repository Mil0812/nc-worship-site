<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BandResource\Pages;
use App\Filament\Resources\BandResource\RelationManagers;
use App\Models\Band;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Storage;

class BandResource extends Resource
{
    protected static ?string $model = Band::class;
    protected static ?string $navigationIcon = 'heroicon-s-users';

    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ??
            __('filament.band.plural');
    }

    public static function getNavigationGroup(): string
    {
        return static::$navigationGroup ??
            __('filament.navigation.band_management');
    }

    public static function getModelLabel(): string
    {
        return static::$modelLabel ??
            __('filament.band.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return static::$pluralModelLabel ??
            __('filament.band.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('filament.band.name'))
                    ->required()
                    ->unique()
                    ->maxLength(30),
                FileUpload::make('image')
                    ->label(__('filament.band.image'))
                    ->image()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                    ->maxSize(5120)
                    ->disk('public')
                    ->directory('bands')
                    ->imageResizeMode('cover')
                    ->imageResizeTargetWidth('200')
                    ->imageResizeTargetHeight('200')
                    ->nullable()
                    ->getUploadedFileNameForStorageUsing(function ($file) {
                        return 'band-' . uniqid() . '.' . $file->getClientOriginalExtension();
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label(__('filament.band.image'))
                    ->getStateUsing(fn ($record) => $record->image ? Storage::url($record->image) : null)
                    ->circular(),
                TextColumn::make('name')
                    ->label(__('filament.band.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('users_count')
                    ->label(__('filament.band.users_count'))
                    ->counts('users')
                    ->sortable(),
            ])
            ->filters([
                //
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
           RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBands::route('/'),
            'create' => Pages\CreateBand::route('/create'),
            'edit' => Pages\EditBand::route('/{record}/edit'),
        ];
    }
}
