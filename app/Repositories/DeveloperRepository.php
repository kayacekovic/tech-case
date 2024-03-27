<?php

namespace App\Repositories;

use App\Models\Developer;
use Illuminate\Support\Collection;

class DeveloperRepository
{
    public function get(): Collection
    {
        return Developer::query()
            ->select('id', 'name')
            ->get();
    }

    public function getDevelopersForTaskAssigment(): Collection
    {
        return Developer::query()
            ->with(['tasks' => function ($q) {
                $q->select('id', 'developer_id', 'due_date');
            }])
            ->orderByDesc('ability_level')
            ->get();
    }

    public function count(): int
    {
        return Developer::query()->count();
    }
}
