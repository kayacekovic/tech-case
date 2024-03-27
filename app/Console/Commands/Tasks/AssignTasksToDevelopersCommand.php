<?php

namespace App\Console\Commands\Tasks;

use App\Models\Developer;
use App\Models\Task;
use App\Repositories\DeveloperRepository;
use App\Repositories\SprintRepository;
use App\Repositories\TaskRepository;
use App\Services\SprintService;
use App\Services\TaskAssigmentService;
use Carbon\Carbon;
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
    protected $description = 'Assign all tasks to developers.';

    /**
     * Execute the console command.
     */
    public function handle(
        TaskAssigmentService $taskAssigmentService,
        SprintService $sprintService,
        DeveloperRepository $developerRepository,
        SprintRepository $sprintRepository,
        TaskRepository $taskRepository,
    ): int {
        $tasks = $taskRepository->getUnassignedTasks();
        $developers = $developerRepository->getDevelopersForTaskAssigment();

        $sprint = $sprintRepository->getActiveSprint();
        if (!$sprint) {
            $sprintStartDate = $sprintService->findSprintStartDate(Carbon::now());
            $sprint = $sprintService->createNewSprint($sprintStartDate, true);
        }

        $assignedTasks = $sprint->tasks()->get();

        $bar = $this->output->createProgressBar($tasks->count());
        $bar->start();

        /** @var Task $task */
        foreach ($tasks as $task) {
            $totalEffortForCurrentSprint = $assignedTasks->where('current_sprint_id', $sprint->id)
                ->sum('effort');
            $availableEffortForCurrentSprint = $sprintService->getDevelopersAvailableEffortForSprint($developers, $sprint);

            if ($totalEffortForCurrentSprint >= $availableEffortForCurrentSprint) {
                $sprintStartDate = $sprintService->findSprintStartDate($sprint->end_date->addDays(1));
                $sprint = $sprintService->createNewSprint($sprintStartDate);
            }

            /** @var Developer $developer */
            foreach ($developers as $developer) {
                $totalDeveloperEffortForCurrentSprint = $assignedTasks->where('developer_id', $developer->id)
                    ->where('current_sprint_id', $sprint->id)
                    ->sum('effort');

                $availableDeveloperEffortForCurrentSprint = $developer->getAvailableEffortForSprint($sprint);
                if ($totalDeveloperEffortForCurrentSprint >= $availableDeveloperEffortForCurrentSprint) {
                    continue;
                }

                $developerEffortForTask = $task->effort / $developer->ability_level;
                $developerLastAssignedTask = $assignedTasks->where('developer_id', $developer->id)->last();

                $startDate = $developerLastAssignedTask->due_date ?? Carbon::now();
                $dueDate = $taskAssigmentService->findDueDate($startDate, $developerEffortForTask);

                $assignedTask = $taskAssigmentService->assignTask($task, $developer, $sprint, $dueDate);

                $assignedTask->current_sprint_id = $sprint->id;
                $assignedTasks->push($assignedTask);

                break;
            }

            $bar->advance();
        }

        $bar->finish();

        return Command::SUCCESS;
    }
}
