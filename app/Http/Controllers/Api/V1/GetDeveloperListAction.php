<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\DeveloperResource;
use App\Repositories\DeveloperRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetDeveloperListAction extends Controller
{
    public function __construct(protected readonly DeveloperRepository $developerRepository)
    {
    }

    public function __invoke(): AnonymousResourceCollection
    {
        $developers = $this->developerRepository->get();

        return DeveloperResource::collection($developers);
    }
}
