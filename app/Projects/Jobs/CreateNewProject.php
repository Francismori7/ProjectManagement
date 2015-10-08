<?php

namespace App\Projects\Jobs;

use App\Contracts\Projects\ProjectRepository;
use App\Core\Jobs\Job;
use App\Projects\Models\Project;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateNewProject extends Job implements SelfHandling
{
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
        $project = $this->data instanceof Project ?
            $this->data :
            (new Project)->setName($this->data['name'])
                ->setDescription($this->data['description']);

        $projects->save($project);
        $projects->flush();

        return $project;
    }

    /**
     * Create a new job instance.
     *
     * @param array|Project $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}
