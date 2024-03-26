<?php

namespace App\Console\Commands\Tasks;

use App\Repositories\DeveloperRepository;
use App\Repositories\TaskRepository;
use Illuminate\Console\Command;

class AssignTasksToDevelopersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:assign-tasks-to-developers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(
        TaskRepository $taskRepository,
        DeveloperRepository $developerRepository
    ) {
        $tasks = $taskRepository->getUnassignedTasks();
        $developers = $developerRepository->getDevelopersForTaskAssigment();
    }
}
