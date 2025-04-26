<?php

namespace App\Enums;

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
            self::ADMIN => 'danger',
            self::USER => 'success',
            self::GROUP_MEMBER => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ADMIN => 'heroicon-o-shield-check',
            self::USER => 'heroicon-o-user',
            self::GROUP_MEMBER => 'heroicon-o-users',
        };
    }
}
