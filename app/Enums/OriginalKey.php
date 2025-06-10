<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
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
    case H = 'H';

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
            self::C => Color::hex('#3a6a94'),
            self::CSharp => Color::hex('#426f9e'),
            self::D => Color::hex('#4b87b6'),
            self::DSharp => Color::hex('#4c94cc'),
            self::E => Color::hex('#4ca4df'),
            self::F => Color::hex('#47b3ea'),
            self::FSharp => Color::hex('#37c6f6'),
            self::G => Color::hex('#35d0f7'),
            self::GSharp => Color::hex('#32e1f4'),
            self::A => Color::hex('#25ebfa'),
            self::ASharp => Color::hex('#00ffff'),
            self::H => Color::hex('#99ffff'),
            default => Color::hex('gray'),
        };
    }

    public function getIcon(): ?string
    {
        return 'heroicon-s-musical-note';
    }
}
