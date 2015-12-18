<?php

namespace App\Projects\Events;

use App\Core\Events\Event;
use App\Projects\Models\Invitation;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EmailWasInvitedToProject extends Event implements ShouldBroadcast
{
    /**
     * @var Invitation
     */
    public $invitation;

    /**
     * EmailWasInvitedToProject constructor.
     *
     * @param Invitation $invitation
     */
    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [
            'projects.' . $this->invitation->project_id,
            'users.' . $this->invitation->host_id
        ];
    }
}
