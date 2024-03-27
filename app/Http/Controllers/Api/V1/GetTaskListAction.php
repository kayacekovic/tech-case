<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\TaskIndexRequest;
use App\Http\Resources\V1\TaskResource;
use App\Repositories\TaskRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetTaskListAction extends Controller
{
    public function __construct(protected readonly TaskRepository $taskRepository)
    {
    }

    public function __invoke(TaskIndexRequest $request): AnonymousResourceCollection
    {
        $tasks = $this->taskRepository->get(
            $request->get('sprint_id'),
            $request->get('developer_id'),
        );

        return TaskResource::collection($tasks);
    }
}
