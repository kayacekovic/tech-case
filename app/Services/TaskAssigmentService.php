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

        $dueDate = (clone $startDate);
        if ($startDate->isWeekend()) {
            $dueDate->next(Carbon::MONDAY)
                ->setHour($workingStartTime)
                ->setMinute(0)
                ->setSecond(0);
        } elseif ($startDate->hour >= $workingEndTime) {
            $dueDate->addDays()
                ->setHour($workingStartTime)
                ->setMinute(0)
                ->setSecond(0);
        } elseif ($startDate->hour < $workingStartTime) {
            $dueDate->setHour($workingStartTime)
                ->setMinute(0)
                ->setSecond(0);
        }

        $dueDate->addHours($developerEffort);

        do {
            $dueDateHour = $dueDate->hour;
            if (0 === $dueDateHour) {
                $dueDateHour = 24;
            }

            $isValidDueDate = ($dueDateHour >= $workingStartTime && $dueDateHour <= $workingEndTime);

            if (!$isValidDueDate) {
                $overTime = $dueDateHour - $workingEndTime;

                $dueDate->addDays()
                    ->setHour($workingStartTime + $overTime)
                    ->setMinute(0)
                    ->setSecond(0);
            }

            if ($dueDate->isWeekend()) {
                $dueDateHour = $workingStartTime;
                if (isset($overTime)) {
                    $dueDateHour += $overTime;
                }

                $dueDate->next(Carbon::MONDAY)
                    ->setHour($dueDateHour)
                    ->setMinute(0)
                    ->setSecond(0);
            }
        } while (!$isValidDueDate);

        return $dueDate;
    }
}
