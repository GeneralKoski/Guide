<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Album>
 */
class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'album_name' => $this->faker->text(20),
            'album_thumb' => $this->faker->imageUrl(),
            'description' => $this->faker->text(120),
            'user_id' => User::factory(),
            'created_at' => $this->faker->dateTime(),
        ];
    }
}