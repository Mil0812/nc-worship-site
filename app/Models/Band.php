<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperBand
 */
class Band extends Model
{
    use HasFactory, HasUlids;

    public $timestamps = false;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function setLists(): HasMany
    {
        return $this->hasMany(SetList::class);
    }

    public function scopeWithLeaders($query)
    {
        return $query->with(['users' => fn ($q) => $q->wherePivot('is_leader', true)]);
    }
}
