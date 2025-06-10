<?php

namespace App\Filament\Resources\SetListResource\Pages;

use App\Filament\Resources\SetListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSetList extends EditRecord
{
    protected static string $resource = SetListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
