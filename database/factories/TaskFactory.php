<?php

namespace Database\Factories;

use App\Enums\TaskStatuses;
use App\Models\Developer;
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
        $developer = Developer::query()
            ->inRandomOrder()
            ->first();

        return [
            'title' => fake()->realText(90),
            'developer_id' => optional($developer)->id,
            'status' => fake()->randomElement(TaskStatuses::values()),
            'duration' => rand(1, 24),
            'difficulty' => rand(1, 5),
        ];
    }
}
