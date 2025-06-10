<?php

namespace App\Models;

use App\Models\Traits\HasSeo;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

/**
 * @mixin IdeHelperTutorial
 */
class Tutorial extends Model
{
    use HasFactory, HasSeo, HasUlids;

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }

    public static function generateSlugFromRelations($song, $instrument): string
    {

        $instrumentName = $instrument ? $instrument->name : '';
        $combinedName = "{$song->name} {$instrumentName}";

        $maxBaseLength = 120;
        $truncatedName = Str::limit($combinedName, $maxBaseLength, '');
        $baseSlug = Str::slug($truncatedName);
        $slug = $baseSlug;
        $counter = 1;


        while (Tutorial::where('slug', $slug)->exists()) {
            $suffix = "-{$counter}";
            $maxSlugLength = 128 - strlen($suffix);
            $slug = Str::limit($baseSlug, $maxSlugLength, '') . $suffix;
            $counter++;
        }


        return $slug;
    }

    public function song(): BelongsTo
    {
        return $this->belongsTo(Song::class);
    }

    public function instrument(): BelongsTo
    {
        return $this->belongsTo(Instrument::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

}
