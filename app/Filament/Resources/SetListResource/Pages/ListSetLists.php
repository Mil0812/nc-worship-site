<?php

namespace App\Filament\Resources\SetListResource\Pages;

use App\Filament\Resources\SetListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSetLists extends ListRecords
{
    protected static string $resource = SetListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
