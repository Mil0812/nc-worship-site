<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TimeSignature: string implements HasColor, HasLabel
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
            self::TWO_FOUR, self::THREE_FOUR => Color::hex('#FF6347'),
            self::FOUR_FOUR => Color::hex('#FF7F50'),
            self::FIVE_FOUR, self::SEVEN_EIGHT => Color::hex('#FFD700'),
            self::SIX_EIGHT => Color::hex('#F0E68C'),
        };
    }
}
