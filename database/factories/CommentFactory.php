<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::all('id')->pluck('id')->toArray();
        $taskIds = Task::all('id')->pluck('id')->toArray();
        return [
            'body' => $this->faker->paragraph(),
            'user_id' => $this->faker->randomElement($userIds),
            'task_id' => $this->faker->randomElement($taskIds),
        ];
    }
}
