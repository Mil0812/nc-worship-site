<?php

namespace App\Filament\Resources\SetListResource\RelationManagers;

use App\Enums\OriginalKey;
use App\Models\SetListSong;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class SongsRelationManager extends RelationManager
{
    protected static string $relationship = 'songs';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return static::$title ?? __('filament.song.plural');
    }

    public function form(Form $form): Form
    {
        return $form
            ->model(SetListSong::class)
            ->schema([
                Forms\Components\Select::make('song_id')
                    ->label(__('filament.song.name'))
                    ->relationship('song', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('number')
                    ->label(__('filament.set_list.number_in_order'))
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->rules(function ($livewire, $record) {
                        $setListId = $livewire->getOwnerRecord()->id;
                        $recordId = $record?->id;
                        return [
                            Rule::unique('set_list_song', 'number')
                                ->where('set_list_id', $setListId)
                                ->ignore($recordId, 'id'),
                        ];
                    }),
                Forms\Components\Select::make('leader_id')
                    ->label(__('filament.set_list.leader_of_song'))
                    ->relationship('leader', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Forms\Components\Select::make('key')
                    ->label(__('filament.pad.key'))
                    ->options(OriginalKey::class)
                    ->enum(OriginalKey::class),
                Forms\Components\Select::make('pad_id')
                    ->label(__('filament.pad.name'))
                    ->relationship('pad', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        $owner = $this->getOwnerRecord();
        $songs = $owner->songs;

        Log::info('SongsRelationManager: Owner Record Check', [
            'owner_id' => $owner->id,
            'songs_count' => $songs->count(),
            'songs' => $songs->toArray(),
        ]);

        return $table
            ->recordTitleAttribute('song.name')
            ->columns([
                Tables\Columns\TextColumn::make('pivot.number')
                    ->label(__('filament.set_list.number_in_order'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('pivot.song.name')
                    ->label(__('filament.song.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('pivot.key')
                    ->label(__('filament.pad.key'))
                    ->badge()
                    ->color(fn ($record) => $record->pivot->key->getColor()),
                Tables\Columns\TextColumn::make('pivot.leader.name')
                    ->label(__('filament.set_list.leader_of_song'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('pivot.pad.name')
                    ->label(__('filament.pad.name'))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label(__('filament.actions.attach_song'))
                    ->modalHeading(__('filament.actions.attach_song'))
                    ->form(fn (Form $form) => $form
                        ->model(SetListSong::class)
                    ->schema([
                        Forms\Components\Select::make('song_id')
                            ->label(__('filament.song.name'))
                            ->relationship('song', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('number')
                            ->label(__('filament.set_list.number_in_order'))
                            ->numeric()
                            ->minValue(1)
                            ->required()
                            ->rules(function ($livewire) {
                                $setListId = $livewire->getOwnerRecord()->id;
                                return [
                                    Rule::unique('set_list_song', 'number')
                                        ->where('set_list_id', $setListId),
                                ];
                            })
                        ->default(function ($livewire) {
                            $setListId = $livewire->getOwnerRecord()->id;
                            $maxNumber = SetListSong::where('set_list_id',
                                $setListId)->max('number');
                            return $maxNumber + 1;
                        }),
                        Forms\Components\Select::make('leader_id')
                            ->label(__('filament.set_list.leader_of_song'))
                            ->relationship('leader', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Forms\Components\Select::make('key')
                            ->label(__('filament.pad.key'))
                            ->options(OriginalKey::class)
                            ->enum(OriginalKey::class)
                            ->nullable(),
                        Forms\Components\Select::make('pad_id')
                            ->label(__('filament.pad.name'))
                            ->relationship('pad', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
            ]))
            ->action(function (array $data, RelationManager $livewire) {
                $owner = $livewire->getOwnerRecord();
                Log::info('SongsRelationManager: Attach Action', [
                    'owner_id' => $owner->id,
                    'data' => $data,
                ]);
                $owner->songs()->attach($data['song_id'], [
                    'number' => $data['number'],
                    'leader_id' => $data['leader_id'] ?? null,
                    'key' => $data['key'],
                    'pad_id' => $data['pad_id'],
                ]);
            }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ])
            ->defaultSort('number');
    }
}
