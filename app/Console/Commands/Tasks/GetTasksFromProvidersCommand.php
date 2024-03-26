<?php

namespace App\Console\Commands\Tasks;

use App\Repositories\TaskRepository;
use Illuminate\Console\Command;

class GetTasksFromProvidersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:get-tasks-from-providers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(TaskRepository $taskRepository)
    {
    }
}
