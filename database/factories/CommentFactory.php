<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Song;
use App\Models\Tutorial;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        $commentable = fake()->randomElement([
            Song::inRandomOrder()->first() ?? Song::factory()->create(),
            Tutorial::inRandomOrder()->first() ?? Tutorial::factory()->create(),
        ]);

        return [
            'user_id' => User::factory(),
            'content' => fake()->paragraph,
            'commentable_id' => $commentable->id,
            'commentable_type' => get_class($commentable),
        ];
    }

    public function reply(): self
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => Comment::factory(),
        ]);
    }
}
