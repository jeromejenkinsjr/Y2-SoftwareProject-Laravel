<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'genre' => $this->faker->randomElement(['Adventure', 'Puzzle', 'Educational']),
        ];
    }
};