<?php

namespace App\Projects\Jobs;

use App\Auth\Models\User;
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
     * @var User
     */
    private $leader;

    /**
     * Create a new job instance.
     *
     * @param array|Project $data
     * @param User $leader
     */
    public function __construct($data, User $leader)
    {
        $this->data = $data;
        $this->leader = $leader;
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
        $project = new Project($this->data);

        $projects->save($project);

        $project->users()->attach($this->leader, ['role' => 'leader']);

        return $project;
    }
}
