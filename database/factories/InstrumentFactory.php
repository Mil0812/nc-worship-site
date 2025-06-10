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
            'name' => fake()->unique()->randomElement(['Акустична гітара', 'Бас', 'Барабани', 'Піаніно', 'Саксофон', 'Електрогітара']),
            'icon' => fake()->imageUrl(100, 100, 'instruments'),
        ];
    }
}
