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

    public static function getColumns(): array
    {
        $columns = [];

        foreach (self::cases() as $case) {
            $columns[] = [
                'id' => $case->value,
                'title' => $case->label(),
                'tasks' => [],
            ];
        }

        return $columns;
    }
}
