<?php

namespace Database\Factories;

use App\Enums\TaskStatuses;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
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
        return [
            'title' => fake()->realText(90),
            'status' => fake()->randomElement(TaskStatuses::values()),
            'duration' => rand(1, 12),
            'difficulty' => rand(1, 5),
        ];
    }
}
