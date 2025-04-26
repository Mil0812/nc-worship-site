<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'role' => fake()->randomElement(Role::cases()),
            'email' => fake()->unique()->safeEmail,
            'password' => Hash::make('Password123$'),
            'avatar' => fake()->optional()->imageUrl(200, 200, 'people'),
            'telegram_id' => fake()->optional()->numerify('#########'),
            'receive_notifications' => fake()->boolean(70),
            'email_verified_at' => fake()->optional()->dateTimeThisYear,
        ];
    }
}
