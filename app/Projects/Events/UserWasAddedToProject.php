<?php

namespace App\Projects\Events;

use App\Auth\Models\User;
use App\Core\Events\Event;
use App\Projects\Models\Project;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserWasAddedToProject extends Event implements ShouldBroadcast
{
    /**
     * @var User
     */
    public $user;
    /**
     * @var Project
     */
    public $project;
    /**
     * @var User
     */
    public $host;

    /**
     * UserWasAddedToProject constructor.
     *
     * @param User $user
     * @param Project $project
     * @param User $host
     */
    public function __construct(User $user, Project $project, User $host)
    {
        $this->user = $user;
        $this->project = $project;
        $this->host = $host;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [
            'projects.' . $this->project->id,
            'users.' . $this->host->id,
            'users.' . $this->user->id,
        ];
    }
}