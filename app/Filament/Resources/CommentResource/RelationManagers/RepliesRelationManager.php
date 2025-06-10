<?php

namespace App\Filament\Resources\CommentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RepliesRelationManager extends RelationManager
{
    protected static string $relationship = 'replies';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return static::$title ?? __('filament.comment.replies');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(Auth::id())
                    ->required(),
                Forms\Components\Hidden::make('commentable_type')
                    ->default(function() {
                        return $this->getOwnerRecord()->commentable_type;
                    })
                    ->required(),
                Forms\Components\Hidden::make('commentable_id')
                    ->default(function() {
                        return $this->getOwnerRecord()->commentable_id;
                    })
                    ->required(),
                Forms\Components\Textarea::make('content')
                    ->label(__('filament.comment.reply_content'))
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('filament.user.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('content')
                    ->label(__('filament.comment.reply_content'))
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament.comment.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('filament.actions.reply'))
                    ->modalHeading(__('filament.actions.reply')),
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
