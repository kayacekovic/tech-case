<?php

namespace App\Repositories;

use App\Data\SprintData;
use App\Models\Sprint;
use Illuminate\Support\Collection;

class SprintRepository
{
    public function get(): Collection
    {
        return Sprint::query()
            ->orderBy('order_num')
            ->get();
    }

    public function getActiveSprint(): ?Sprint
    {
        return Sprint::query()
            ->where('is_active', 1)
            ->first();
    }

    public function create(SprintData $data): Sprint
    {
        $sprint = new Sprint();
        $sprint->name = $data->name;
        $sprint->order_num = Sprint::query()->max('order_num') + 1;
        $sprint->start_date = $data->startDate;
        $sprint->end_date = $data->endDate;
        $sprint->is_active = $data->isActive;
        $sprint->save();

        return $sprint;
    }

    public function update(Sprint $sprint, SprintData $data): Sprint
    {
        $sprint->name = $data->name;
        $sprint->start_date = $data->startDate;
        $sprint->end_date = $data->endDate;
        $sprint->is_active = $data->isActive;
        $sprint->save();

        return $sprint;
    }
}
