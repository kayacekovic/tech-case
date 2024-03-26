<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\DeveloperRepository;
use App\Repositories\TaskRepository;
use Illuminate\Http\JsonResponse;

class GetTasksStatsAction extends Controller
{
    public function __construct(
        protected readonly TaskRepository $taskRepository,
        protected readonly DeveloperRepository $developerRepository,
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $tasksCount = $this->taskRepository->count();
        $developersCount = $this->developerRepository->count();

        $lastTaskByDueDate = $this->taskRepository->getLastTaskByDueDate();
        $dueDate = optional($lastTaskByDueDate)->due_date;

        return response()->json([
            'tasks_count' => $tasksCount,
            'developers_count' => $developersCount,
            'estimated_all_tasks_due_date' => optional($dueDate)->format('d.m.Y'),
        ]);
    }
}
