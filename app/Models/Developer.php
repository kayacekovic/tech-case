<?php

namespace App\Models;

use App\Enums\WorkingHours;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Developer extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function getAvailableWorkHourForSprint(Sprint $sprint): int
    {
        $date = $sprint->start_date;

        if ($date->hour < WorkingHours::START_HOUR->value) {
            $date->setHour(WorkingHours::START_HOUR->value)
                ->setMinute(0)
                ->setSecond(0);
        }

        $workHour = 0;
        while ($date->lt($sprint->end_date)) {
            $nextDate = (clone $date)->addDay()
                ->setHour(WorkingHours::START_HOUR->value)
                ->setMinute(0)
                ->setSecond(0);

            if ($date->isWeekend()) {
                $date = $nextDate;

                continue;
            }

            $endDate = (clone $date)
                ->setHour(WorkingHours::END_HOUR->value)
                ->setMinute(0)
                ->setSecond(0);

            $workHour += $date->diffInHours($endDate);

            $date = $nextDate;
        }

        return $workHour;
    }

    public function getAvailableEffortForSprint(Sprint $sprint): int
    {
        return $this->getAvailableWorkHourForSprint($sprint) * $this->ability_level;
    }
}
