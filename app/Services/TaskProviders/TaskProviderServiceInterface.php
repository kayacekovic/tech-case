<?php

namespace App\Services\TaskProviders;

use Illuminate\Support\Collection;

interface TaskProviderServiceInterface
{
    public function getTasks(): Collection;
}
