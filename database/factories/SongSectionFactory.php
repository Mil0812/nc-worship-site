<?php

namespace Database\Factories;

use App\Enums\SongSectionType;
use App\Models\Song;
use App\Models\SongSection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SongSection>
 */
class SongSectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'song_id' => Song::factory(),
            'section_type' => fake()->randomElement(SongSectionType::cases()),
            'order' => fake()->numberBetween(0, 10),
            'lyrics' => fake()->paragraphs(2, true),
            'chords' => fake()->optional()->words(5, true),
        ];
    }
}
