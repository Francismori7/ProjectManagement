<?php
/**
 * Created by PhpStorm.
 * User: Trycia Turgeon
 * Date: 2015-12-03
 * Time: 17:34
 */

namespace App\Projects\Jobs;


use App\Core\Jobs\Job;
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
     */
    public function handle()
    {
        $invitee = $this->invitation->email;
        $host = $this->invitation->host;
        $project = $this->invitation->project;
        $invitation = $this->invitation;

        \Mail::send('emails.projects.invite', compact('invitation', 'invitee', 'host', 'project'),
            function (Message $m) {
                $m->to($this->invitation->email);
                $m->subject("Invitation to {$this->invitation->project->name} from {$this->invitation->host->first_name}");
            });
    }
}