<?php

namespace Database\Factories;

use App\Models\Band;
use App\Models\SetList;
use Illuminate\Database\Eloquent\Factories\Factory;

class SetListFactory extends Factory
{
    protected $model = SetList::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'band_id' => Band::query()->inRandomOrder()->first()->id ?? Band::factory(),
            'performed_at' => fake()->dateTimeBetween('now', '+1 year'),
        ];
    }
}
