<?php
/**
 * Created by PhpStorm.
 * User: 1494770
 * Date: 2015-12-04
 * Time: 10:08
 */

namespace App\Auth\Jobs;


use App\Auth\Models\User;
use App\Core\Jobs\Job;
use App\Projects\Models\Invitation;
use DB;
use Illuminate\Contracts\Bus\SelfHandling;

class HandleInvitationsOnceRegistered extends Job implements SelfHandling
{
    /**
     * @var User
     */
    private $user;


    /**
     * Handle the job.
     */
    public function handle()
    {
        /**
         * Adding the user to the project he was invited for.
         *
         * First, we need to retrieve all invitations for this email.
         */
        $invitations = [];

        foreach (Invitation::query()
                     ->where('email', $this->invitation->email)
                     ->get()
                     ->pluck('project_id') as $invitation) {
            /**
             * We'll make sure the role we add is a simple user, not a leader. They can
             * promote the user later if they need to.
             */
            $invitations[$invitation]['role'] = '';
        }

        /**
         * We'll sync the projects for the newly created user, essentially assigning the
         * user as a project user for every invitations he got.
         */
        $this->user->projects()->sync($invitations);

        /**
         * We no longer need the invitations for that user (based on email) since we added
         * the user to all the projects he was invited to.
         */
        DB::table('invitations')->where('email', $this->user->email)->delete();
    }

    /**
     * HandleInvitationsOnceRegistered constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}