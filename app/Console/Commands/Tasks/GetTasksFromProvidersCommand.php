<?php

namespace App\Console\Commands\Tasks;

use App\Enums\TaskProviders;
use App\Repositories\TaskRepository;
use App\Services\TaskProviders\TaskProviderService;
use Illuminate\Console\Command;

class GetTasksFromProvidersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:get-tasks-from-providers {--provider=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get tasks from providers.';

    /**
     * Execute the console command.
     */
    public function handle(TaskRepository $taskRepository): int
    {
        if ($this->option('provider')) {
            $provider = TaskProviders::tryFrom($this->option('provider'));

            /** @var TaskProviderService $providerService */
            $providerService = app($provider->getService());
            $tasks = $providerService->getTasks();

            foreach ($tasks as $taskData) {
                $taskRepository->create($taskData);
            }

            return Command::SUCCESS;
        }

        $providers = TaskProviders::cases();
        foreach ($providers as $provider) {
            /** @var TaskProviderService $providerService */
            $providerService = app($provider->getService());
            $tasks = $providerService->getTasks();

            foreach ($tasks as $taskData) {
                $taskRepository->create($taskData);
            }
        }

        return Command::SUCCESS;
    }
}
