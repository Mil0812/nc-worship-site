<?php

namespace App\Models;

use App\Enums\OriginalKey;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @mixin IdeHelperSetListSong
 */
class SetListSong extends Pivot
{
    use HasFactory, HasUlids;

    protected $table = 'set_list_songs';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'key' => OriginalKey::class,
        ];
    }

    public function setList(): BelongsTo
    {
        return $this->belongsTo(SetList::class, 'set_list_id');
    }

    public function song(): BelongsTo
    {
        return $this->belongsTo(Song::class);
    }

    public function leader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function pad(): BelongsTo
    {
        return $this->belongsTo(Pad::class);
    }
}
