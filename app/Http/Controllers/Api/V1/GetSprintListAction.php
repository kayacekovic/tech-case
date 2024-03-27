<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\SprintResource;
use App\Repositories\SprintRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetSprintListAction extends Controller
{
    public function __construct(protected readonly SprintRepository $sprintRepository)
    {
    }

    public function __invoke(): AnonymousResourceCollection
    {
        $sprints = $this->sprintRepository->get();

        return SprintResource::collection($sprints);
    }
}
