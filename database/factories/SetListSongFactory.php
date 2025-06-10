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
            'set_list_id' => SetList::factory(),
            'song_id' => Song::factory(),
            'number' => function (array $attributes) {
                $setListId = $attributes['set_list_id'] ?? SetList::factory()->create()->id;
                $maxNumber = SetListSong::where('set_list_id', $setListId)->max('number') ?? 0;
                return $maxNumber + 1;
            },
            'leader_id' => User::query()->inRandomOrder()->first()->id ?? User::factory(),
            'key' => fake()->randomElement(OriginalKey::cases()),
            'pad_id' => Pad::query()->inRandomOrder()->first()->id ?? Pad::factory(),
        ];
    }
}
