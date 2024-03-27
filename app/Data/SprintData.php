<?php

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class SprintData extends Data
{
    public function __construct(
        public string $name,
        public Carbon $startDate,
        public Carbon $endDate,
        public bool $isActive,
    ) {
    }
}
