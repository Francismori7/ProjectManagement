<?php

namespace App\Auth\Jobs;

use App\Auth\Models\User;
use App\Contracts\Auth\UserRepository;
use App\Core\Jobs\Job;
use App\Projects\Models\Invitation;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CreateNewUser extends Job implements SelfHandling
{
    use DispatchesJobs;

    /**
     * @var array
     */
    private $data;
    /**
     * @var Invitation
     */
    private $invitation;

    /**
     * Create a new job instance.
     *
     * @param array|User $data
     * @param Invitation $invitation
     */
    public function __construct($data, Invitation $invitation)
    {
        $this->data = $data;
        $this->invitation = $invitation;
    }

    /**
     * Execute the job.
     *
     * @param UserRepository $users
     *
     * @return User
     */
    public function handle(UserRepository $users)
    {
        $user = new User($this->data);
        $user->password = bcrypt($this->data['password']);

        $users->save($user);

        $this->dispatch(new HandleInvitationsOnceRegistered($user, $this->invitation));
        $this->dispatch(new SendRegistrationEmail($user));

        return $user;
    }
}
