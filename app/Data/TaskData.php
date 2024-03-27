<?php

namespace App\Data;

use App\Enums\TaskProviders;
use App\Enums\TaskStatuses;
use Carbon\Carbon;
use Spatie\LaravelData\Data;

class TaskData extends Data
{
    public function __construct(
        public string $title,
        public TaskStatuses $status,
        public int $duration,
        public int $difficulty,
        public ?int $developerId = null,
        public ?Carbon $dueDate = null,
        public ?TaskProviders $provider = null,
    ) {
    }
}
