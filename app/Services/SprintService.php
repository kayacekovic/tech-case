<?php

namespace App\Services;

use App\Data\SprintData;
use App\Enums\WorkingHours;
use App\Models\Developer;
use App\Models\Sprint;
use App\Models\Task;
use App\Repositories\SprintRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class SprintService
{
    public function __construct(public readonly SprintRepository $sprintRepository)
    {
    }

    public function createNewSprint(Carbon $startDate, bool $isActive = false): Sprint
    {
        if ($isActive) {
            $activeSprint = $this->sprintRepository->getActiveSprint();
            if ($activeSprint) {
                $activeSprintData = SprintData::from($activeSprint);
                $activeSprintData->isActive = false;

                $this->sprintRepository->update($activeSprint, $activeSprintData);
            }
        }

        return $this->sprintRepository->create(new SprintData(
            name: 'WYGN',
            startDate: $startDate,
            endDate: (clone $startDate)->addWeeks(),
            isActive: $isActive,
        ));
    }

    public function findSprintStartDate(Carbon $startDate): Carbon
    {
        if ($startDate->hour > WorkingHours::END_HOUR->value && $startDate->hour <= 23) {
            $startDate->addDays();
        }

        if ($startDate->isWeekend()) {
            $startDate->next(Carbon::MONDAY);
        }

        return $startDate->setHour(WorkingHours::START_HOUR->value)
            ->setMinute(0)
            ->setSecond(0);
    }

    public function getDeveloperEffortForTask(Developer $developer, Task $task)
    {
        return round(($task->difficulty / $developer->ability_level) * $task->duration);
    }

    public function getDeveloperTotalEffortForSprint(Collection $assignedTasks, Developer $developer, Sprint $sprint)
    {
        $tasks = $assignedTasks->where('developer_id', $developer->id)
            ->where('current_sprint_id', $sprint->id);

        return $tasks->reduce(function (int $carry, Task $task) use ($developer) {
            return $carry + $this->getDeveloperEffortForTask($developer, $task);
        }, 0);
    }
}
