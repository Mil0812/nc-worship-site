<?php

namespace App\Models;

use App\Enums\OriginalKey;
use App\Enums\TimeSignature;
use App\Models\Traits\HasSeo;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin IdeHelperSong
 */
class Song extends Model
{
    use HasFactory, HasSeo, HasUlids;

    protected function casts(): array
    {
        return [
            'original_key' => OriginalKey::class,
            'time_signature' => TimeSignature::class,
        ];
    }

    public function setLists(): BelongsToMany
    {
        return $this->belongsToMany(SetList::class, 'set_list_songs')
            ->using(SetListSong::class)
            ->withPivot(['number', 'leader_id', 'key', 'pad_id']);
    }

    public function tutorials(): HasMany
    {
        return $this->hasMany(Tutorial::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function scopeByKey($query, OriginalKey $key)
    {
        return $query->where('original_key', $key);
    }

    public function scopeByBpmRange($query, int $min, int $max)
    {
        return $query->whereBetween('bpm', [$min, $max]);
    }
}
