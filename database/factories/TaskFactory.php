<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::all('id')->pluck('id')->toArray();
        $authorId = $this->faker->randomElement($userIds);
        unset($userIds[$authorId]);

        $projectIds = Project::all('id')->pluck('id')->toArray();

        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['new', 'in_progress', 'completed', 'cancelled']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high', 'critical']),
            'due_date' => now()->addDays($this->faker->numberBetween(1, 30)),
            'author_id' => $authorId,
            'assignee_id' => $this->faker->randomElement($userIds),
            'project_id' => $this->faker->randomElement($projectIds),
        ];
    }
}
