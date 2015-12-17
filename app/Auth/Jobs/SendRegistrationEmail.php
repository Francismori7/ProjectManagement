<?php
/**
 * Created by PhpStorm.
 * User: 1494770
 * Date: 2015-12-04
 * Time: 09:45
 */

namespace App\Auth\Jobs;


use App\Auth\Models\User;
use App\Core\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Mail;

class SendRegistrationEmail extends Job implements ShouldQueue, SelfHandling
{
    /**
     * @var User
     */
    private $user;

    /**
     * SendRegistrationEmail constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handle the job.
     */
    public function handle()
    {
        if ($this->user->trashed()) {
            return false;
        }

        Mail::send('emails.auth.register', ['user' => $this->user->load('projects')], function (Message $m) {
            $m->to($this->user->email);
            $m->subject('Thank you for registering an account!');
        });
    }
}