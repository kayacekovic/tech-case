<?php

namespace App\Repositories;

use App\Data\TaskData;
use App\Models\Task;
use Illuminate\Support\Collection;

class TaskRepository
{
    public function findById(int $taskId): ?Task
    {
        return Task::query()->find($taskId);
    }

    public function get(): Collection
    {
        return Task::query()
            ->with(['developer' => fn ($q) => $q->select('id', 'name')])
            ->get();
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
