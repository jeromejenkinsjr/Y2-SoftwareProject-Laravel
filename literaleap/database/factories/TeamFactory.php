<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'team_code' => strtoupper($this->faker->unique()->bothify('TEAM###')),
            'created_by' => \App\Models\User::factory(),
        ];
    }
}