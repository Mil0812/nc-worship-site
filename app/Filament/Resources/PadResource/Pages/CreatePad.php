<?php

namespace App\Filament\Resources\PadResource\Pages;

use App\Filament\Resources\PadResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePad extends CreateRecord
{
    protected static string $resource = PadResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
