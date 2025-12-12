<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'genre' => fake()->randomElement(['Acción', 'Aventura', 'RPG', 'Deportes', 'Estrategia', 'Shooter']),
            'platform' => fake()->randomElement(['PlayStation 5', 'Xbox Series X', 'PC', 'Nintendo Switch', 'PlayStation 4']),
        ];
    }
}
