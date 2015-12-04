<?php

namespace App\Projects\Listeners;

use App\Auth\Models\User;
use App\Core\Events\Event;
use App\Core\Jobs\Job;
use App\Projects\Models\Project;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;

class SendUserAddedToProjectEmail extends Job implements ShouldQueue, SelfHandling
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var Project
     */
    private $project;
    /**
     * @var User
     */
    private $host;
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * SendUserAddedToProjectEmail constructor.
     *
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the job.
     *
     * @param Event $event
     */
    public function handle(Event $event) {
        $user = $event->user;
        $project = $event->project;
        $host = $event->host;

        $view = 'emails.project.user_added_to_project';

        $this->mailer->send($view, compact('user', 'project', 'host'), function(Message $m) use ($user, $project, $host) {
            $m->to($user->email);
        });
    }
}