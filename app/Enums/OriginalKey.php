<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum OriginalKey: string implements HasColor, HasIcon, HasLabel
{
    case C = 'C';
    case CSharp = 'C#';
    case D = 'D';
    case DSharp = 'D#';
    case E = 'E';
    case F = 'F';
    case FSharp = 'F#';
    case G = 'G';
    case GSharp = 'G#';
    case A = 'A';
    case ASharp = 'A#';
    case B = 'B';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CSharp => 'C♯',
            self::DSharp => 'D♯',
            self::FSharp => 'F♯',
            self::GSharp => 'G♯',
            self::ASharp => 'A♯',
            default => $this->value,
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::C, self::E, self::A => 'primary',
            self::CSharp, self::F, self::ASharp => 'success',
            self::D, self::FSharp, self::B => 'warning',
            self::DSharp, self::G, self::GSharp => 'danger',
            default => 'gray',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::C, self::CSharp, self::D, self::DSharp => 'heroicon-o-musical-note',
            self::E, self::F, self::FSharp, self::G => 'heroicon-s-musical-note',
            self::GSharp, self::A, self::ASharp, self::B => 'heroicon-m-musical-note',
            default => null,
        };
    }
}
