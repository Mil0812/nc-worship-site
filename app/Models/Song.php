<?php

namespace App\Models;

use App\Enums\OriginalKey;
use App\Enums\SongSectionType;
use App\Enums\SongType;
use App\Enums\TimeSignature;
use App\Models\Traits\HasSeo;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @mixin IdeHelperSong
 */
class Song extends Model
{
    use HasFactory, HasSeo, HasUlids;

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($song) {
            $song->name = Str::limit($song->name, 100, '');
            $song->slug = $song->slug ?? self::generateSlug($song->name);
            $song->meta_title = $song->meta_title ?? self::makeMetaTitle($song->name);
            $song->meta_description = $song->meta_description ?? self::makeMetaDescription($song->name);
        });
    }

    protected function casts(): array
    {
        return [
            'type' => SongType::class,
            'original_key' => OriginalKey::class,
            'time_signature' => TimeSignature::class,
        ];
    }

    public function songSections(): HasMany
    {
        return $this->hasMany(SongSection::class)->orderBy('order');
    }

    public function setLists(): BelongsToMany
    {
        return $this->belongsToMany(SetList::class, 'set_list_song')
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
        return $this->hasMany(Favourite::class);
    }

    public function scopeByKey($query, OriginalKey $key)
    {
        return $query->where('original_key', $key);
    }

    public function scopeByBpmRange($query, int $min, int $max)
    {
        return $query->whereBetween('bpm', [$min, $max]);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image ? Storage::url($this->image) : asset('default-images/example-song-image.png');
    }

    public function getAudioUrlAttribute(): string
    {
        return $this->audio ? Storage::url($this->audio) : '';
    }
}
