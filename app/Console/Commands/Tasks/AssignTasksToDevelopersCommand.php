<?php

namespace App\Console\Commands\Tasks;

use App\Models\Developer;
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

    public function __construct(
        private readonly TaskAssigmentService $taskAssigmentService,
        private readonly SprintService $sprintService,
        private readonly DeveloperRepository $developerRepository,
        private readonly SprintRepository $sprintRepository,
        private readonly TaskRepository $taskRepository,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $unassignedTasks = $this->taskRepository->getUnassignedTasks();
        $developers = $this->developerRepository->getDevelopersForTaskAssigment();

        $sprint = $this->sprintRepository->getActiveSprint();
        if (!$sprint) {
            $sprintStartDate = $this->sprintService->findSprintStartDate(Carbon::now());
            $sprint = $this->sprintService->createNewSprint($sprintStartDate, true);
        }

        $totalUnassignedTasksCount = $unassignedTasks->count();
        $assignedTasks = $sprint->tasks()->get();

        foreach ($unassignedTasks as $task) {
            $developersHaveEffortForSprint = $developers->reject(function (Developer $developer) use ($assignedTasks, $sprint) {
                $totalEffort = $this->sprintService->getDeveloperTotalEffortForSprint($assignedTasks, $developer, $sprint);
                $totalEffort = round($totalEffort / 5) * 5;

                return $totalEffort >= $developer->weekly_work_hour;
            });

            if (!$developersHaveEffortForSprint->count()) {
                $sprintStartDate = $this->sprintService->findSprintStartDate($sprint->end_date->addDays(1));
                $sprint = $this->sprintService->createNewSprint($sprintStartDate);
            }

            /** @var Developer $developer */
            foreach ($developers as $developer) {
                $developerEffortForTask = $this->sprintService->getDeveloperEffortForTask($developer, $task);
                $developerTotalEffort = $this->sprintService->getDeveloperTotalEffortForSprint($assignedTasks, $developer, $sprint);

                if ($developerTotalEffort >= $developer->weekly_work_hour) {
                    continue;
                }

                $developerLastAssignedTask = $assignedTasks->where('developer_id', $developer->id)->last();

                $startDate = optional($developerLastAssignedTask)->due_date ?? $sprint->start_date;
                if (optional($developerLastAssignedTask)->current_sprint_id !== $sprint->id) {
                    $startDate = $sprint->start_date;
                }

                $dueDate = $this->taskAssigmentService->findDueDate($startDate, $developerEffortForTask);

                $assignedTask = $this->taskAssigmentService->assignTask($task, $developer, $sprint, $dueDate);
                $assignedTasks->push($assignedTask);

                --$totalUnassignedTasksCount;

                break;
            }
        }

        return Command::SUCCESS;
    }
}
