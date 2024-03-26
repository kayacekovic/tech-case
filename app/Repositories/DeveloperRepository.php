<?php

namespace App\Repositories;

use App\Models\Developer;
use Illuminate\Support\Collection;

class DeveloperRepository
{
    public function getDevelopersForTaskAssigment(): Collection
    {
        return Developer::query()
            ->with(['tasks' => function ($q) {
                $q->select('id', 'developer_id', 'due_date');
            }])
            ->get();
    }

    public function count(): int
    {
        return Developer::query()->count();
    }
}
