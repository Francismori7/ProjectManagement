<?php

namespace App\Projects\Jobs;

use App\Contracts\Projects\TaskRepository;
use App\Core\Jobs\Job;
use App\Projects\Models\Task;
use Illuminate\Contracts\Bus\SelfHandling;

class DeleteTask extends Job implements SelfHandling
{
    /**
     * @var Task
     */
    private $task;

    /**
     * Create a new job instance.
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     *
     * @param TaskRepository $tasks
     *
     * @return Task
     */
    public function handle(TaskRepository $tasks)
    {
        $tasks->delete($this->task);

        return ['deleted' => true];
    }
}
