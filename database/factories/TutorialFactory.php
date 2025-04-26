<?php

namespace Database\Factories;

use App\Models\Instrument;
use App\Models\Song;
use App\Models\Tutorial;
use Illuminate\Database\Eloquent\Factories\Factory;

class TutorialFactory extends Factory
{
    protected $model = Tutorial::class;

    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'slug' => Tutorial::generateSlug($title),
            'song_id' => Song::query()->inRandomOrder()->first()->id ?? Song::factory(),
            'instrument_id' => Instrument::query()->inRandomOrder()->first()->id ?? Instrument::factory(),
            'video' => 'https://youtube.com/watch?v='.fake()->uuid,
            'description' => fake()->paragraphs(2, true),
            'is_public' => fake()->boolean(80), // 80% шанс бути публічним
            'meta_title' => Tutorial::makeMetaTitle($title),
            'meta_description' => Tutorial::makeMetaDescription(fake()->paragraph),
            'meta_image' => fake()->optional()->imageUrl(1200, 630, 'tutorials'),
        ];
    }
}
