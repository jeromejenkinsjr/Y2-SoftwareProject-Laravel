<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(3),
            'file' => $this->faker->word() . '.js',
            'thumbnail' => $this->faker->image('public/images', 640, 480, null, false),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}