<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait HasSeo
{
    public static function generateSlug(string $title): string
    {
        return str($title)->slug().'-'.str(str()->random(6))->lower();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public static function makeMetaTitle(string $title): string
    {
        return $title.' | '.config('app.name');
    }

    public static function makeMetaDescription(string $description): string
    {
        return Str::length($description) > 376 ? Str::substr($description, 0, 373).'...' : $description;
    }

    public function scopeBySlug(Builder $query, string $slug): Builder
    {
        return $query->where('slug', $slug);
    }
}
