<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum SongType: string implements HasColor, HasIcon, HasLabel
{
    case AUTHORS = 'authors';
    case TRANSLATED = 'translated';
    case GENERAL = 'general';

    public function getLabel(): ?string
    {
        return __("song-types.{$this->value}");
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::AUTHORS => Color::hex('#FF6347'),
            self::TRANSLATED => Color::hex('#FFD700'),
            self::GENERAL => Color::hex('#FF7F50'),
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::AUTHORS => 'heroicon-s-at-symbol',
            self::TRANSLATED => 'heroicon-s-language',
            self::GENERAL => 'heroicon-s-globe-alt',
        };
    }
}
