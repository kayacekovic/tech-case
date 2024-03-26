<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TaskResource;
use App\Repositories\TaskRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetTaskListAction extends Controller
{
    public function __construct(protected readonly TaskRepository $taskRepository)
    {
    }

    public function __invoke(): AnonymousResourceCollection
    {
        $tasks = $this->taskRepository->get();

        return TaskResource::collection($tasks);
    }
}
