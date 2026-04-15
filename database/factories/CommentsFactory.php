<?php

namespace Database\Factories;

use App\Models\comments;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<comments>
 */
class CommentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'body' => $this->faker->paragraph(),
            'user_id' => rand(1, 10),
            'task_id' => rand(1, 10),
            'created_at' => now(),
        ];
    }
}
