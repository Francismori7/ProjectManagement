<?php

namespace App\Projects\Jobs;

use App\Contracts\Projects\ProjectRepository;
use App\Core\Jobs\Job;
use App\Projects\Models\Project;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateProject extends Job implements SelfHandling
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
     * Execute the job.
     *
     * @param ProjectRepository $projects
     *
     * @return Project
     */
    public function handle(ProjectRepository $projects)
    {
        $this->project->setName($this->data['name'])
            ->setDescription($this->data['description']);

        $projects->save($this->project);
        $projects->flush();

        return $this->project;
    }

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
}
