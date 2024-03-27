<?php

namespace App\Enums;

use App\Services\TaskProviders\JiraTaskProviderService;
use App\Services\TaskProviders\TrelloTaskProviderService;

enum TaskProviders: string
{
    case JIRA = 'jira';

    case TRELLO = 'trello';

    public function getService(): string
    {
        return match ($this) {
            self::JIRA => JiraTaskProviderService::class,
            self::TRELLO => TrelloTaskProviderService::class,
        };
    }
}
