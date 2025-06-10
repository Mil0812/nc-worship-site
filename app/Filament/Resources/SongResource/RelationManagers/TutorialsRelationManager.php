<?php

namespace App\Filament\Resources\SongResource\RelationManagers;

use App\Models\Instrument;
use App\Models\Song;
use App\Models\Tutorial;
use Exception;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TutorialsRelationManager extends RelationManager
{
    protected static string $relationship = 'tutorials';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return static::$title ?? __('filament.song.tutorials');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('instrument_id')
                    ->label(__('filament.instrument.name'))
                    ->relationship('instrument', 'name')
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->required()
                    ->afterStateUpdated(function ($state, $set, $livewire) {
                        $song = $livewire->getOwnerRecord();
                        $instrument = Instrument::find($state);
                        $slug = Tutorial::generateSlugFromRelations($song, $instrument);

                        $set('slug', $slug);
                    }),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(128)
                    ->rules(['max:128'])
                    ->unique(ignoreRecord: true)
                    ->dehydrated()
                    ->helperText('Automatically generated from song and instrument names'),
                Forms\Components\TextInput::make('video')
                    ->label(__('filament.song.tutorial_video'))
                    ->required()
                    ->url()
                    ->maxLength(2048)
                    ->placeholder('e.g., https://www.youtube.com/watch?v=VIDEO_ID'),
                Forms\Components\Toggle::make('is_public')
                    ->label(__('filament.song.is_public'))
                    ->default(true),

                Section::make('SEO')
            ->schema(
                [
                    Forms\Components\TextInput::make('meta_title')
                        ->label(__('filament.song.meta_title'))
                        ->maxLength(128)
                        ->rules(['max:128'])
                        ->nullable(),
                    Forms\Components\Textarea::make('meta_description')
                        ->label(__('filament.song.meta_description'))
                        ->maxLength(376)
                        ->nullable(),
                    Forms\Components\FileUpload::make('meta_image')
                        ->label(__('filament.song.meta_image'))
                        ->image()
                        ->directory('tutorial-images-meta')
                        ->maxSize(2048)
                        ->nullable(),
                ]
            )
            ]);
    }

    /**
     * @throws Exception
     */
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('slug')
            ->columns([
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('instrument.name')
                    ->label(__('filament.instrument.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('video')
                    ->label(__('filament.song.tutorial_video'))
                    ->formatStateUsing(fn ($state) => Str::limit($state, 50))
                    ->url(fn ($state) => $state),
                Tables\Columns\IconColumn::make('is_public')
                    ->label(__('filament.song.is_public'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament.song.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_public'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('filament.actions.attach_tutorial'))
                    ->modalHeading(__('filament.actions.attach_tutorial')),
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
}
