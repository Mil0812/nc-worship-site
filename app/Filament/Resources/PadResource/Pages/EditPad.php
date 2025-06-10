<?php

namespace App\Filament\Resources\PadResource\Pages;

use App\Filament\Resources\PadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPad extends EditRecord
{
    protected static string $resource = PadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
