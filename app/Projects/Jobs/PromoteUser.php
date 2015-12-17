<?php

namespace App\Projects\Jobs;

use App\Auth\Models\User;
use App\Core\Jobs\Job;
use App\Projects\Models\Project;

class PromoteUser extends Job
{
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
     * @param Project $project
     * @param User $user
     */
    public function __construct(Project $project, User $user)
    {
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
        $this->project->users()->updateExistingPivot($this->user->id, ['role' => 'leader']);

        return ['promoted' => $this->user->id];
    }
}
