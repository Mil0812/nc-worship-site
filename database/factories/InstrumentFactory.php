<?php

namespace Database\Factories;

use App\Models\Instrument;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstrumentFactory extends Factory
{
    protected $model = Instrument::class;

    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Гітара', 'Бас', 'Ударні', 'Вокал', 'Клавішні']),
            'icon' => fake()->optional()->imageUrl(100, 100, 'instruments'),
        ];
    }
}
