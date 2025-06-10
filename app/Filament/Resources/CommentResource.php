<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Filament\Resources\CommentResource\RelationManagers;
use App\Models\Comment;
use App\Models\Song;
use App\Models\Tutorial;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;
    protected static ?string $navigationIcon = 'heroicon-s-chat-bubble-bottom-center-text';

    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ??
            __('filament.comment.plural');
    }

    public static function getNavigationGroup(): string
    {
        return static::$navigationGroup ??
            __('filament.navigation.user_interaction');
    }

    public static function getModelLabel(): string
    {
        return static::$modelLabel ??
            __('filament.comment.singular');
    }
    public static function getPluralModelLabel(): string
    {
        return static::$pluralModelLabel ??
            __('filament.comment.plural');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(Auth::id())
                    ->required(),
                Forms\Components\Select::make('commentable_type')
                    ->label(__('filament.comment.commentable_type'))
                    ->options([
                        'App\Models\Song' => 'Song',
                        'App\Models\Tutorial' => 'Tutorial',
                    ])
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) => $set('commentable_id', null))
                    ->required()
                    ->disabled(fn ($record) => $record && $record->user_id !== Auth::id()),
                Forms\Components\Select::make('commentable_id')
                    ->label(__('filament.comment.commentable_name'))
                    ->options(function ($get) {
                        $type = $get('commentable_type');
                        if ($type === 'App\Models\Song') {
                            return Song::pluck('name', 'id');
                        }
                        if ($type === 'App\Models\Tutorial') {
                            return Tutorial::pluck('slug', 'id');
                        }
                        return [];
                    })
                    ->searchable()
                    ->preload()
                    ->required()
                    ->disabled(fn ($record) => $record && $record->user_id !== Auth::id()),
                Forms\Components\Textarea::make('content')
                    ->label(__('filament.comment.content'))
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull()
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
                Tables\Columns\TextColumn::make('commentable_type')
                    ->label(__('filament.comment.commentable_type'))
                    ->formatStateUsing(fn ($state) => class_basename($state))
                    ->sortable(),
                Tables\Columns\TextColumn::make('commentable.name')
                    ->label(__('filament.comment.commentable_name'))
                    ->getStateUsing(function ($record) {
                        if ($record->commentable_type === 'App\Models\Song') {
                            return $record->commentable->name ?? 'N/A';
                        }
                        if ($record->commentable_type === 'App\Models\Tutorial') {
                            return $record->commentable->slug ?? 'N/A';
                        }
                        return 'N/A';
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where(function (Builder $query) use ($search) {
                            $query->whereHasMorph(
                                'commentable',
                                [Song::class],
                                fn (Builder $q) => $q->whereRaw('lower(name::text) LIKE ?', ["%{$search}%"])
                            )
                                ->orWhereHasMorph(
                                    'commentable',
                                    [Tutorial::class],
                                    fn (Builder $q) => $q->whereRaw('lower(slug::text) LIKE ?', ["%{$search}%"])
                                );
                        });
                    }),
                Tables\Columns\TextColumn::make('content')
                    ->label(__('filament.comment.content'))
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament.comment.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('commentable_type')
                    ->options([
                        'App\Models\Song' => 'Song',
                        'App\Models\Tutorial' => 'Tutorial',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(__('filament.actions.reply'))
                    ->icon('heroicon-s-chat-bubble-left-right'),
                Tables\Actions\DeleteAction::make()
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
             RelationManagers\RepliesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
