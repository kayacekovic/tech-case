<?php

namespace App\Services;

use App\Enums\WorkingHours;
use App\Models\Developer;
use App\Models\Sprint;
use App\Models\Task;
use App\Repositories\DeveloperRepository;
use App\Repositories\TaskRepository;
use Carbon\Carbon;

class TaskAssigmentService
{
    public function __construct(
        public readonly TaskRepository $taskRepository,
        public readonly DeveloperRepository $developerRepository
    ) {
    }

    public function assignTask(Task $task, Developer $developer, Sprint $sprint, Carbon $dueDate): Task
    {
        $task->developer_id = $developer->id;
        $task->current_sprint_id = $sprint->id;
        $task->due_date = $dueDate;
        $task->save();

        $task->sprints()->attach($sprint->id, [
            'created_at' => now(),
        ]);

        return $task;
    }

    public function findDueDate(Carbon $startDate, int $developerEffort): Carbon
    {
        $workingStartTime = WorkingHours::START_HOUR->value;
        $workingEndTime = WorkingHours::END_HOUR->value;

        $date = $startDate;
        if ($startDate->isWeekend()) {
            $date->next(Carbon::MONDAY)
                ->setHour($workingStartTime)
                ->setMinute(0)
                ->setSecond(0);
        } elseif ($startDate->hour > $workingEndTime) {
            $date->addDays()
                ->setHour($workingStartTime)
                ->setMinute(0)
                ->setSecond(0);
        } elseif ($startDate->hour < $workingStartTime) {
            $date->setHour($workingStartTime)
                ->setMinute(0)
                ->setSecond(0);
        }

        $date->addHours($developerEffort);

        do {
            $isValidDueDate = ($date->hour >= $workingStartTime && $date->hour < $workingEndTime);

            if (!$isValidDueDate) {
                $overTime = $date->hour - $workingEndTime;

                $date->addDays()
                    ->setHour($workingStartTime + $overTime)
                    ->setMinute(0)
                    ->setSecond(0);
            }

            if ($date->isWeekend()) {
                $date->next(Carbon::MONDAY);
            }
        } while (!$isValidDueDate);

        return $date;
    }
}
