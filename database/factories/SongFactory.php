<?php

namespace Database\Factories;

use App\Enums\OriginalKey;
use App\Enums\SongType;
use App\Enums\TimeSignature;
use App\Models\Song;
use Illuminate\Database\Eloquent\Factories\Factory;

class SongFactory extends Factory
{
    protected $model = Song::class;

    public function definition(): array
    {
        $name = fake()->sentence(3);

        return [
            'name' => $name,
            'slug' => Song::generateSlug($name),
            'author' => fake()->optional()->name(),
            'type' => fake()->randomElement(SongType::cases()),
            'image' => fake()->optional()->imageUrl(640, 480, 'songs'),
            'original_key' => fake()->randomElement(OriginalKey::cases()),
            'bpm' => fake()->numberBetween(60, 180),
            'time_signature' => fake()->randomElement(TimeSignature::cases()),
            'audio' => fake()->optional()->url(),
            'meta_title' => Song::makeMetaTitle($name),
            'meta_description' => Song::makeMetaDescription(fake()->paragraph),
            'meta_image' => fake()->optional()->imageUrl(1200, 630, 'songs'),
        ];
    }
}
