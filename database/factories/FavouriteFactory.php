<?php

namespace Database\Factories;

use App\Models\Favourite;
use App\Models\Song;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavouriteFactory extends Factory
{
    protected $model = Favourite::class;

    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->first()->id ?? User::factory(),
            'song_id' => Song::query()->inRandomOrder()->first()->id ?? Song::factory(),
        ];
    }
}
