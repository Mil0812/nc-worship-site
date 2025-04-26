<?php

namespace Database\Factories;

use App\Enums\OriginalKey;
use App\Models\Pad;
use App\Models\SetList;
use App\Models\SetListSong;
use App\Models\Song;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SetListSongFactory extends Factory
{
    protected $model = SetListSong::class;

    public function definition(): array
    {
        return [
            // 'set_list_id' => SetList::query()->inRandomOrder()->first()->id ?? SetList::factory(),
            'set_list_id' => SetList::factory(),
            // 'song_id' => Song::query()->inRandomOrder()->first()->id ?? Song::factory(),
            'song_id' => Song::factory(),
            'number' => fake()->numberBetween(1, 10),
            'leader_id' => User::query()->inRandomOrder()->first()->id ?? User::factory(),
            'key' => fake()->randomElement(OriginalKey::cases()),
            'pad_id' => Pad::query()->inRandomOrder()->first()->id ?? Pad::factory(),
        ];
    }
}
