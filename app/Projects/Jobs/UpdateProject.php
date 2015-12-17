<?php

namespace App\Projects\Jobs;

use App\Contracts\Projects\ProjectRepository;
use App\Core\Jobs\Job;
use App\Projects\Models\Project;

class UpdateProject extends Job
{
    /**
     * @var Project
     */
    private $project;
    /**
     * @var array
     */
    private $data;

    /**
     * Create a new job instance.
     *
     * @param Project $project
     * @param array $data
     */
    public function __construct(Project $project, $data)
    {
        $this->project = $project;
        $this->data = $data;
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
        $this->project->fill($this->data);

        $projects->save($this->project);

        return $this->project;
    }
}
