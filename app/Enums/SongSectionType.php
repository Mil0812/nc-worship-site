<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum SongSectionType: string implements HasLabel
{
    case VERSE = 'verse';
    case VERSE_1 = 'verse1';
    case VERSE_2 = 'verse2';
    case VERSE_3 = 'verse3';
    case VERSE_4 = 'verse4';
    case CHORUS = 'chorus';
    case CHORUS_2 = 'chorus2';
    case BRIDGE = 'bridge';
    case BRIDGE_2 = 'bridge2';
    case PRE_CHORUS = 'pre_chorus';
    case PRE_CHORUS_2 = 'pre_chorus2';
    case INTRO = 'intro';
    case OUTRO = 'outro';
    case INSTRUMENTAL = 'instrumental';
    case INSERT = 'insert';

    public function getLabel(): ?string
    {
        return __('song-section.song_section.' . $this->value);
    }
}
