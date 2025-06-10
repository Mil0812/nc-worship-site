<?php

namespace App\Filament\Resources\FavoriteResource\Pages;

use App\Filament\Resources\FavouriteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFavourite extends CreateRecord
{
    protected static string $resource = FavouriteResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
