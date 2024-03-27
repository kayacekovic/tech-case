<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\DeveloperRepository;
use App\Repositories\TaskRepository;
use Illuminate\Http\JsonResponse;

class GetTasksStatsAction extends Controller
{
    public function __construct(protected readonly TaskRepository $taskRepository) {
    }

    public function __invoke(): JsonResponse
    {
        $tasksCount = $this->taskRepository->count();
        $assignedTasksCount = $this->taskRepository->assignedTasksCount();

        $lastTaskByDueDate = $this->taskRepository->getLastTaskByDueDate();
        $dueDate = optional($lastTaskByDueDate)->due_date;

        return response()->json([
            'tasks_count' => $tasksCount,
            'assigned_tasks_count' => $assignedTasksCount,
            'estimated_all_tasks_due_date' => optional($dueDate)->format('d/m/Y'),
        ]);
    }
}
