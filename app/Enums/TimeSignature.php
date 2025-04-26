<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TimeSignature: string implements HasColor, HasIcon, HasLabel
{
    case TWO_FOUR = '2/4';
    case THREE_FOUR = '3/4';
    case FOUR_FOUR = '4/4';
    case FIVE_FOUR = '5/4';
    case SIX_EIGHT = '6/8';
    case SEVEN_EIGHT = '7/8';

    public function getLabel(): ?string
    {
        return $this->value;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::FOUR_FOUR => 'primary',  // Common time
            self::TWO_FOUR, self::THREE_FOUR => 'success',  // Simple meters
            self::FIVE_FOUR, self::SEVEN_EIGHT => 'warning',  // Complex meters
            self::SIX_EIGHT => 'info',  // Compound meter
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::TWO_FOUR, self::FOUR_FOUR => 'heroicon-o-clock',
            self::THREE_FOUR, self::FIVE_FOUR => 'heroicon-o-metronome',
            self::SIX_EIGHT, self::SEVEN_EIGHT => 'heroicon-o-musical-note',
        };
    }
}
