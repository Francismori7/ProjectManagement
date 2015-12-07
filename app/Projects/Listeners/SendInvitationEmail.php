<?php

namespace App\Projects\Listeners;

use App\Core\Events\Event;
use App\Core\Jobs\Job;
use App\Projects\Events\EmailWasInvitedToProject;
use App\Projects\Models\Invitation;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;

class SendInvitationEmail extends Job implements ShouldQueue, SelfHandling
{
    /**
     * @var Invitation
     */
    private $invitation;

    /**
     * SendInvitationEmail constructor.
     *
     * @param Invitation $invitation
     */
    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Handle the job.
     *
     * @param Event|EmailWasInvitedToProject $event
     */
    public function handle(Event $event)
    {
        $this->invitation = $event->invitation;

        $invitee = $this->invitation->email;
        $host = $this->invitation->host;
        $project = $this->invitation->project;
        $invitation = $this->invitation;

        $view = 'emails.projects.invite';
        $data = compact('invitation', 'invitee', 'host', 'project');

        \Mail::send($view, $data, function (Message $m) use ($project, $host, $invitation) {
            $fullName = "{$host->first_name} {$host->last_name}";
            $m->sender($host->email, $fullName);

            $m->to($invitation->email)->subject("You were invited to project {$project->name}!");
        });
    }
}