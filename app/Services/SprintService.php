<?php

namespace App\Services;

use App\Data\SprintData;
use App\Enums\WorkingHours;
use App\Models\Developer;
use App\Models\Sprint;
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
        if ($startDate->isWeekend()) {
            $startDate->next(Carbon::MONDAY);
        }

        return $startDate->setHour(WorkingHours::START_HOUR->value)
            ->setMinute(0)
            ->setSecond(0);
    }

    public function getDevelopersAvailableEffortForSprint(Collection $developers, Sprint $sprint)
    {
        return $developers->reduce(function (int $carry, Developer $developer) use ($sprint) {
            return $carry + $developer->getAvailableEffortForSprint($sprint);
        }, 0);
    }
}
