<?php

namespace App\Projects\Jobs;

use App\Contracts\Projects\TaskRepository;
use App\Core\Jobs\Job;
use App\Projects\Models\Task;

class UpdateTask extends Job
{
    /**
     * @var Task
     */
    private $task;
    /**
     * @var array
     */
    private $data;

    /**
     * Create a new job instance.
     *
     * @param Task $task
     * @param array $data
     */
    public function __construct(Task $task, $data)
    {
        $this->task = $task;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @param TaskRepository $tasks
     * @return Task
     */
    public function handle(TaskRepository $tasks)
    {
        $this->task->fill($this->data);

        $tasks->save($this->task);

        return $this->task;
    }
}
