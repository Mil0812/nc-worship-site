<?php

namespace Database\Factories;

use App\Models\Instrument;
use App\Models\Song;
use App\Models\Tutorial;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

class TutorialFactory extends Factory
{
    protected $model = Tutorial::class;

    public function definition(): array
    {
        $song = Song::query()->inRandomOrder()->first() ?? Song::factory()->create();
        $instrument = Instrument::query()->inRandomOrder()->first() ?? Instrument::factory()->create();

        $combinedName = "{$song->name} {$instrument->name}";
        $slug = Tutorial::generateSlugFromRelations($song, $instrument);
        $metaTitle = Tutorial::makeMetaTitle($combinedName);

        return [
            'slug' => $slug,
            'song_id' => $song->id,
            'instrument_id' => $instrument->id,
            'video' => 'https://youtube.com/watch?v='.fake()->uuid,
            'is_public' => fake()->boolean(80),
            'meta_title' => $metaTitle,
            'meta_description' => Tutorial::makeMetaDescription(fake()->paragraph),
            'meta_image' => fake()->optional()->imageUrl(1200, 630, 'tutorials'),
        ];
    }
}
