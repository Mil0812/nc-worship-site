<?php

namespace App\Filament\Resources;

use App\Enums\OriginalKey;
use App\Filament\Resources\PadResource\Pages;
use App\Models\Pad;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;

class PadResource extends Resource
{
    protected static ?string $model = Pad::class;

    protected static ?string $navigationIcon = 'heroicon-s-speaker-wave';

    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ??
            __('filament.pad.plural');
    }

    public static function getNavigationGroup(): string
    {
        return static::$navigationGroup ??
            __('filament.navigation.content_management');
    }

    public static function getModelLabel(): string
    {
        return static::$modelLabel ??
            __('filament.pad.singular');
    }
    public static function getPluralModelLabel(): string
    {
        return static::$pluralModelLabel ??
            __('filament.pad.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('filament.pad.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('key')
                    ->label(__('filament.pad.key'))
                    ->options(OriginalKey::class)
                    ->enum(OriginalKey::class)
                    ->required(),
                Forms\Components\FileUpload::make('audio')
                    ->label(__('filament.pad.audio'))
                    ->disk('public')
                    ->directory('pads')
                    ->visibility('public')
                    ->acceptedFileTypes(['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/x-m4a', 'audio/mp4'])
                    ->maxSize(10240)
                    ->previewable(false)
//                    ->storeFileNamesIn('audio_file_name')
                    ->required()
                    ->afterStateUpdated(function ($state, $set) {
                        if ($state && is_string($state)) {
                            $filePath = storage_path('app/' . $state);
                            if (!file_exists($filePath)) {
                                Log::error('Audio file not found', ['path' => $filePath]);
                                $set('audio', null);
                            }
                        }
                    }),
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
                    ->label(__('filament.pad.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('key')
                    ->label(__('filament.pad.key'))
                    ->badge()
                    ->color(fn ($record) => $record->key?->getColor())
                    ->sortable(),
                Tables\Columns\TextColumn::make('audio')
                    ->label(__('filament.pad.audio'))
                    ->default(__('filament.messages.no_audio'))
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('key')
                    ->options(OriginalKey::class),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPads::route('/'),
            'create' => Pages\CreatePad::route('/create'),
            'edit' => Pages\EditPad::route('/{record}/edit'),
        ];
    }
}
