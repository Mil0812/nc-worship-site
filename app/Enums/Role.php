<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Role: string implements HasColor, HasIcon, HasLabel
{
    case ADMIN = 'admin';
    case USER = 'user';
    case GROUP_MEMBER = 'group_member';

    public function getLabel(): ?string
    {
        return __("roles.{$this->value}");
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ADMIN => Color::hex('#FF6347'),
            self::USER => Color::hex('#FFD700'),
            self::GROUP_MEMBER => Color::hex('#FF7F50'),
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ADMIN => 'heroicon-s-shield-check',
            self::USER => 'heroicon-s-user',
            self::GROUP_MEMBER => 'heroicon-s-users',
        };
    }
}
