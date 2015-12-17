<?php

namespace App\Projects\Jobs;

use App\Auth\Models\User;
use App\Core\Jobs\Job;
use App\Projects\Models\Project;
use App\Projects\Models\Task;

class CreateNewTask extends Job
{
    /**
     * @var array
     */
    private $data;
    /**
     * @var Project
     */
    private $project;
    /**
     * @var User
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @param array|Project $data
     * @param Project $project
     * @param User $user
     */
    public function __construct($data, Project $project, User $user)
    {
        $this->data = $data;
        $this->project = $project;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return Project
     */
    public function handle()
    {
        $task = new Task($this->data);

        $task->host_id = $this->user->id;
        $this->project->tasks()->save($task);

        return $task;
    }
}
