<?php

namespace Database\Factories;

use App\Models\Favorite;
use App\Models\Song;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->first()->id ?? User::factory(),
            'song_id' => Song::query()->inRandomOrder()->first()->id ?? Song::factory(),
        ];
    }
}
