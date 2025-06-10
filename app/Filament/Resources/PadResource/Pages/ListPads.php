<?php

namespace App\Filament\Resources\PadResource\Pages;

use App\Filament\Resources\PadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPads extends ListRecords
{
    protected static string $resource = PadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
