<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstrumentResource\Pages;
use App\Models\Instrument;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InstrumentResource extends Resource
{
    protected static ?string $model = Instrument::class;

    protected static ?string $navigationIcon = 'heroicon-s-musical-note';
    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ??
            __('filament.instrument.plural');
    }

    public static function getNavigationGroup(): string
    {
        return static::$navigationGroup ??
            __('filament.navigation.band_management');
    }

    public static function getModelLabel(): string
    {
        return static::$modelLabel ??
            __('filament.instrument.singular');
    }
    public static function getPluralModelLabel(): string
    {
        return static::$pluralModelLabel ??
            __('filament.instrument.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('filament.instrument.name'))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(30),
                Forms\Components\FileUpload::make('icon')
                    ->label(__('filament.instrument.icon'))
                    ->image()
                    ->visibility('public')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                    ->maxSize(5120)
                    ->disk('public')
                    ->directory('instruments')
                    ->imageResizeMode('cover')
                    ->imageResizeTargetWidth('200')
                    ->imageResizeTargetHeight('200')
                    ->nullable()
                    ->previewable()
                    ->getUploadedFileNameForStorageUsing(function ($file) {
                        return 'instrument-' . uniqid() . '.' . $file->getClientOriginalExtension();
                    })
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('icon')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament.instrument.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('users_count')
                    ->label(__('filament.instrument.users_count'))
                    ->counts('users')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->label(__('filament.actions.attach_musician'))
                ->icon('heroicon-s-user-plus'),
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
            InstrumentResource\RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInstruments::route('/'),
            'create' => Pages\CreateInstrument::route('/create'),
            'edit' => Pages\EditInstrument::route('/{record}/edit'),
        ];
    }
}
