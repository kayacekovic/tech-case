<?php

namespace App\Services\TaskProviders;

use Illuminate\Support\Collection;

abstract class TaskProviderService
{
    protected string $apiUrl;

    public function __construct(protected readonly TaskProviderRequestClient $requestService)
    {
    }

    abstract public function getTasks(): Collection;
}
