<?php

namespace App\Enums;

enum TaskStatuses: int
{
    case TO_DO = 1;

    case IN_PROGRESS = 2;

    case DONE = 3;

    public function label(): string
    {
        return match ($this) {
            self::IN_PROGRESS => 'In Progress',
            self::DONE => 'Done',
            default => 'To Do',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
