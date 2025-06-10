<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @mixin IdeHelperInstrument
 */
class Instrument extends Model
{
    use HasFactory, HasUlids;

    public $timestamps = false;

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($instrument) {
            $instrument->name = Str::limit($instrument->name, 100, '');
        });
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'instrument_user');
    }

    public function tutorials(): HasMany
    {
        return $this->hasMany(Tutorial::class);
    }

    public function getIconUrlAttribute(): string
    {
        return $this->icon ? Storage::url($this->icon) : asset('default-images/example-musical-instrument.png');
    }
}
