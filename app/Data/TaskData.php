<?php

namespace App\Data;

use App\Enums\TaskStatuses;
use Spatie\LaravelData\Data;

class TaskData extends Data
{
    public function __construct(
        public string $title,
        public TaskStatuses $status,
        public int $duration,
        public int $difficulty,
        public ?int $developerId = null,
    ) {
    }
}
