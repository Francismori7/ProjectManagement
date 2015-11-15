<?php

namespace App\Projects\Jobs;

use App\Auth\Models\User;
use App\Core\Jobs\Job;
use App\Projects\Models\Invitation;
use App\Projects\Models\Project;
use Illuminate\Contracts\Bus\SelfHandling;

class InviteUser extends Job implements SelfHandling
{
    /**
     * @var string
     */
    private $email;
    /**
     * @var User
     */
    private $user;
    /**
     * @var Project
     */
    private $project;

    /**
     * Create a new job instance.
     *
     * @param Project $project
     * @param User $user
     * @param string $email
     */
    public function __construct(Project $project, User $user, $email)
    {
        $this->project = $project;
        $this->email = $email;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return Project
     */
    public function handle()
    {
        $invitation = new Invitation();
        $invitation->host_id = $this->user->id;

        $this->project->invitations()->save($invitation);

        // TODO: Send email.

        return [$invitation];
    }
}
