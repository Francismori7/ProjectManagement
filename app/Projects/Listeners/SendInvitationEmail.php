<?php

namespace App\Projects\Listeners;

use App\Core\Events\Event;
use App\Core\Jobs\Job;
use App\Projects\Events\EmailWasInvitedToProject;
use App\Projects\Models\Invitation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;

class SendInvitationEmail extends Job implements ShouldQueue
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

        \Mail::send($view, $data, function (Message $m) use ($data) {
            $fullName = "{$data['host']->first_name} {$data['host']->last_name} (Creaperio)";
            $m->sender(config('mail.from.address'), $fullName);

            $m->to($data['invitee']);
            $m->subject("You were invited to join a project: {$data['project']->name}!");
        });
    }
}