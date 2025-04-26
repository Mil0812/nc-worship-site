<?php

namespace Database\Factories;

use App\Models\Band;
use Illuminate\Database\Eloquent\Factories\Factory;

class BandFactory extends Factory
{
    protected $model = Band::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company,
            'image' => fake()->imageUrl(640, 480, 'bands'),
        ];
    }
}
