<?php

namespace App\Models;

use App\Enums\SongSectionType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperSongSection
 */
class SongSection extends Model{
    use HasFactory, HasUlids;

    protected function casts(): array
    {
        return [
            'section_type' => SongSectionType::class,
        ];
    }

    public function song(): BelongsTo
    {
        return $this->belongsTo(Song::class);
    }
}
