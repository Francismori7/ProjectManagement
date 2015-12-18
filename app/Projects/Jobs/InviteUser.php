<?php

namespace App\Projects\Jobs;

use App\Auth\Models\User;
use App\Core\Jobs\Job;
use App\Projects\Events\EmailWasInvitedToProject;
use App\Projects\Events\UserWasAddedToProject;
use App\Projects\Models\Invitation;
use App\Projects\Models\Project;
use Illuminate\Foundation\Bus\DispatchesJobs;

class InviteUser extends Job
{
    use DispatchesJobs;

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
        /**
         * Verify if the user already exists, if so, just add the user to the project there.
         */
        if ($user = User::whereEmail($this->email)->first()) {
            $user->projects()->attach($this->project->id, ['role' => '']);

            event(new UserWasAddedToProject($user, $this->project, $this->user));

            return ['user_added_to_project'];
        }

        /**
         * User does not exist, let's send an email to allow registration.
         */
        $invitation = new Invitation([
            'host_id' => $this->user->id,
            'email' => $this->email,
        ]);

        $this->project->invitations()->save($invitation);

        event(new EmailWasInvitedToProject($invitation));

        return [$invitation];
    }
}
