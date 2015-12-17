<?php

namespace App\Projects\Jobs;

use App\Contracts\Projects\TaskRepository;
use App\Core\Jobs\Job;
use App\Projects\Models\Task;

class RestoreTask extends Job
{
    /**
     * @var Task
     */
    private $task;

    /**
     * Execute the job.
     *
     * @param TaskRepository $tasks
     *
     * @return Task
     */
    public function handle(TaskRepository $tasks)
    {
        $this->task->restore();

        $tasks->save($this->task);

        return $this->task->fresh();
    }

    /**
     * Create a new job instance.
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }
}
