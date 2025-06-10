<?php

namespace App\Models;

use App\Notifications\SetlistPublished;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Log;

/**
 * @mixin IdeHelperSetList
 */
class SetList extends Model
{
    use HasFactory, HasUlids;

    protected $casts = [
        'performed_at' => 'date',
    ];

    public function band(): BelongsTo
    {
        return $this->belongsTo(Band::class);
    }

    public function songs(): BelongsToMany
    {
        return $this->belongsToMany(Song::class, 'set_list_song')
            ->using(SetListSong::class)
            ->withPivot(['number', 'leader_id', 'key', 'pad_id'])
            ->withTimestamps();
//        ->orderByPivot('number');
    }

    public function scopeOrdered($query)
    {
        return $query->with(['songs' => fn ($q) => $q->orderByPivot('number')]);
    }

    protected static function booted(): void
    {
        static::created(function (SetList $setlist) {

            if (!$setlist->band) {
                return;
            }


            if ($setlist->band->users->isEmpty()) {
                return;
            }


            foreach ($setlist->band->users as $user) {
                $user->notify(new SetlistPublished($setlist));
            }
        });
    }
}
