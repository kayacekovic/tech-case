<?php

namespace App\Repositories;

use App\Data\TaskData;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class TaskRepository
{
    public function findById(int $taskId): ?Task
    {
        return Task::query()->find($taskId);
    }

    public function getLastTaskByDueDate(): ?Task
    {
        return Task::query()
            ->orderByDesc('due_date')
            ->first();
    }

    public function get(int $sprintId = null, int $developerId = null): Collection
    {
        return Task::query()
            ->with([
                'currentSprint',
                'developer' => fn ($q) => $q->select('id', 'name'),
            ])
            ->when($sprintId, function (Builder $q) use ($sprintId) {
                $q->whereRelation('sprints', 'id', $sprintId);
            })
            ->when($developerId, function (Builder $q) use ($developerId) {
                $q->where('developer_id', $developerId);
            })
            ->orderBy('created_at')
            ->orderBy('due_date')
            ->get();
    }

    public function getUnassignedTasks(): Collection
    {
        return Task::query()
            ->whereNull('developer_id')
            ->orderByDesc('difficulty')
            ->get();
    }

    public function count(): int
    {
        return Task::query()->count();
    }

    public function assignedTasksCount(): int
    {
        return Task::query()
            ->whereNotNull('developer_id')
            ->count();
    }

    public function create(TaskData $data): Task
    {
        $task = new Task();
        $task->developer_id = $data->developerId;
        $task->title = $data->title;
        $task->status = $data->status;
        $task->duration = $data->duration;
        $task->difficulty = $data->difficulty;
        $task->save();

        return $task;
    }

    public function update(Task $task, TaskData $data): Task
    {
        $task->developer_id = $data->developerId;
        $task->title = $data->title;
        $task->status = $data->status;
        $task->duration = $data->duration;
        $task->difficulty = $data->difficulty;

        return $task;
    }
}
