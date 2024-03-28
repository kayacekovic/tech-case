<?php

namespace Tests\Feature;

use App\Repositories\TaskRepository;
use Psy\Command\Command;
use Tests\TestCase;

class TaskProviderTest extends TestCase
{
    public function testGetTasksFromProvidersCommand(): void
    {
        $this->artisan('tasks:get-tasks-from-providers')
            ->assertExitCode(Command::SUCCESS);
    }

    public function testAssignTasksCommand(): void
    {
        $this->artisan('tasks:assign-tasks-to-developers')
            ->assertExitCode(Command::SUCCESS);

        /** @var TaskRepository $taskRepository */
        $taskRepository = app(TaskRepository::class);
        $unassignedTasks = $taskRepository->getUnassignedTasks();

        $this->assertCount(0, $unassignedTasks);
    }
}
