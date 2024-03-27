<?php

namespace App\Services\TaskProviders;

use App\Data\TaskData;
use App\Enums\TaskProviders;
use App\Enums\TaskStatuses;
use Illuminate\Support\Collection;

class JiraTaskProviderService extends TaskProviderService
{
    public function getTasks(): Collection
    {
        $tasks = collect([]);

        // todo: get from api
        $providerTasks = json_decode(file_get_contents(storage_path('/data/jira_tasks.json')), true);
        foreach ($providerTasks as $providerTask) {
            $task = new TaskData(
                title: $providerTask['id'],
                status: TaskStatuses::TO_DO,
                duration: $providerTask['sure'],
                difficulty: $providerTask['zorluk'],
                provider: TaskProviders::JIRA,
            );

            $tasks->push($task);
        }

        return $tasks;
    }
}
