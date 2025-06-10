<?php

namespace App\Filament\Resources;

use App\Enums\OriginalKey;
use App\Enums\SongSectionType;
use App\Enums\SongType;
use App\Enums\TimeSignature;
use App\Filament\Resources\SongResource\Pages;
use App\Filament\Resources\SongResource\RelationManagers\TutorialsRelationManager;
use App\Models\Song;
use Exception;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Tapp\FilamentValueRangeFilter\Filters\ValueRangeFilter;

class SongResource extends Resource
{
    protected static ?string $model = Song::class;
    protected static ?string $navigationIcon = 'heroicon-s-document-text';
    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ??
            __('filament.song.plural');
    }

    public static function getNavigationGroup(): string
    {
        return static::$navigationGroup ??
            __('filament.navigation.content_management');
    }

    public static function getModelLabel(): string
    {
        return static::$modelLabel ??
            __('filament.song.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return static::$pluralModelLabel ??
            __('filament.song.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('filament.song.name'))
                    ->required()
                    ->maxLength(100)
                    ->rules(['max:100'])
                    ->live(onBlur: true)
                    ->unique(ignoreRecord: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Song::generateSlug($state));
                        $set('meta_title', Song::makeMetaTitle($state));
                    }),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(128)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('author')
                    ->label(__('filament.song.author'))
                    ->maxLength(128)
                    ->nullable(),

                Forms\Components\Select::make('type')
                    ->label(__('filament.song.type'))
                    ->options(SongType::class)
                    ->enum(SongType::class)
                    ->required(),

                Forms\Components\FileUpload::make('image')
                    ->label(__('filament.song.image'))
                    ->image()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                    ->maxSize(5120)
                    ->disk('public')
                    ->directory('song-images')
                    ->imageResizeMode('cover')
                    ->imageResizeTargetWidth('200')
                    ->imageResizeTargetHeight('200')
                    ->nullable()
                    ->getUploadedFileNameForStorageUsing(function ($file) {
                        return 'song-' . uniqid() . '.' . $file->getClientOriginalExtension();
                    }),

                Forms\Components\Select::make('original_key')
                    ->label(__('filament.song.original_key'))
                    ->options(OriginalKey::class)
                    ->enum(OriginalKey::class)
                    ->required(),

                Forms\Components\TextInput::make('bpm')
                    ->label(__('filament.song.bpm'))
                    ->numeric()
                    ->minValue(60)
                    ->maxValue(180)
                    ->rules(['min:60', 'max:180'])
                    ->required(),

                Forms\Components\Select::make('time_signature')
                    ->label(__('filament.song.time_signature'))
                    ->options(TimeSignature::class)
                    ->enum(TimeSignature::class)
                    ->nullable(),

                FileUpload::make('audio')
                    ->label(__('filament.song.audio'))
                    ->nullable()
                    ->acceptedFileTypes(['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/mp3'])
                    ->maxSize(51200)
                    ->disk('public')
                    ->directory('song-records'),

                Repeater::make('sections')
                    ->label(__('filament.song.sections'))
                    ->relationship('songSections')
                    ->schema([
                        Select::make('section_type')
                            ->label(__('filament.song.section_type'))
                            ->options(SongSectionType::class)
                            ->required()
                            ->default(SongSectionType::CHORUS->value),

                        Textarea::make('lyrics')
                            ->label(__('filament.song.lyrics'))
                            ->required()
                            ->rows(5),

                        Textarea::make('chords')
                            ->label(__('filament.song.chords'))
                            ->nullable()
                            ->rows(5),
                    ])
                    ->orderColumn('order')
                    ->collapsible()
                    ->itemLabel(function (array $state): ?string {
                        if (!isset($state['section_type'])) {
                            return null;
                        }
                        $sectionType = SongSectionType::tryFrom($state['section_type']);
                        return $sectionType ? mb_strtoupper($sectionType->getLabel()) : null;
                    })->columnSpanFull(),

                Forms\Components\Section::make('SEO')
            ->schema(
                [
                    Forms\Components\TextInput::make('meta_title')
                        ->label(__('filament.song.meta_title'))
                        ->maxLength(128)
                        ->nullable(),
                    Forms\Components\Textarea::make('meta_description')
                        ->label(__('filament.song.meta_description'))
                        ->maxLength(376)
                        ->nullable(),
                    Forms\Components\FileUpload::make('meta_image')
                        ->label(__('filament.song.meta_image'))
                        ->image()
                        ->directory('song-images-meta')
                        ->maxSize(2048)
                        ->nullable(),
                ]
            )
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            // Щоб упевнитися, що туторіали завантажуються разом з інструментами
            ->modifyQueryUsing(fn ($query) => $query->with(['tutorials.instrument']))
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('filament.song.image'))
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament.song.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('author')
                    ->label(__('filament.song.author'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('filament.song.type'))
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('original_key')
                    ->label(__('filament.song.original_key'))
                    ->badge()
                    ->color(fn ($record) => $record->original_key?->getColor())
                    ->sortable(),
                Tables\Columns\TextColumn::make('bpm')
                    ->label(__('filament.song.bpm'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('time_signature')
                    ->label(__('filament.song.time_signature'))
                    ->badge()
                    ->color(fn ($record) => $record->time_signature?->getColor())
                    ->sortable(),
                Tables\Columns\TextColumn::make('tutorials_count')
                    ->label(__('filament.song.tutorials_count'))
                    ->counts('tutorials')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tutorial_instruments')
                    ->label(__('filament.song.tutorial_instruments'))
                    ->getStateUsing(fn ($record) => $record->tutorials->pluck('instrument.name')->join(', '))
                    ->default('No tutorials'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('original_key')
                    ->options(OriginalKey::class),
                Tables\Filters\SelectFilter::make('time_signature')
                    ->options(TimeSignature::class),
                ValueRangeFilter::make('bpm'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(__('filament.actions.attach_tutorial'))
                    ->icon('heroicon-s-cursor-arrow-rays'),
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
            TutorialsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSongs::route('/'),
            'create' => Pages\CreateSong::route('/create'),
            'edit' => Pages\EditSong::route('/{record}/edit'),
        ];
    }
}
