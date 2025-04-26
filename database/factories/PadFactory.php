<?php

namespace Database\Factories;

use App\Enums\OriginalKey;
use App\Models\Pad;
use Illuminate\Database\Eloquent\Factories\Factory;

class PadFactory extends Factory
{
    protected $model = Pad::class;

    public function definition(): array
    {
        return [
            'name' => fake()->word.' Pad',
            'key' => fake()->randomElement(OriginalKey::cases()),
            'audio' => fake()->url,
        ];
    }
}
