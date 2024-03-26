<?php

namespace Database\Factories;

use App\Enums\TaskStatuses;
use App\Models\Developer;
use Carbon\Carbon;
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

        $duration = rand(1, 24);
        $createdAt = fake()->dateTimeBetween('now', '+4 weeks');

        return [
            'title' => fake()->realText(90),
            'developer_id' => optional($developer)->id,
            'status' => fake()->randomElement(TaskStatuses::values()),
            'duration' => $duration,
            'difficulty' => rand(1, 5),
            'due_date' => Carbon::parse($createdAt)->addHours($duration),
            'created_at' => $createdAt,
        ];
    }
}
