<?php

namespace App\Projects\Jobs;

use App\Auth\Models\User;
use App\Core\Jobs\Job;
use App\Projects\Models\Comment;
use App\Projects\Models\Project;

class CreateNewComment extends Job
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
        $comment = new Comment($this->data);

        $comment->user_id = $this->user->id;
        $this->project->comments()->save($comment);

        return $comment;
    }
}
