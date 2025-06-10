<?php

namespace App\Models;

use App\Enums\OriginalKey;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin IdeHelperPad
 */
class Pad extends Model
{
    use HasFactory, HasUlids;

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'key' => OriginalKey::class,
        ];
    }

    public function getAudioUrlAttribute(): ?string
    {
//        return $this->audio ? Storage::disk('public')->url($this->audio) : null;
        return $this->audio ? Storage::url($this->audio) : null;
    }

    public function setListSongs(): BelongsToMany
    {
        return $this->belongsToMany(SetList::class, 'set_list_song')
            ->using(SetListSong::class)
            ->withPivot(['song_id', 'number', 'leader_id', 'key']);
    }
}
