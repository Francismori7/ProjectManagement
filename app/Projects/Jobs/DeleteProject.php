<?php

namespace App\Projects\Jobs;

use App\Contracts\Projects\ProjectRepository;
use App\Core\Jobs\Job;
use App\Projects\Models\Project;

class DeleteProject extends Job
{
    /**
     * @var Project
     */
    private $project;

    /**
     * Create a new job instance.
     *
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Execute the job.
     *
     * @param ProjectRepository $projects
     *
     * @return Project
     */
    public function handle(ProjectRepository $projects)
    {
        $projects->delete($this->project);

        return ['deleted' => true];
    }
}
