<?php

namespace App\Core\Console\Commands\Permissions;

use App\Contracts\Auth\UserRepository;
use Illuminate\Console\Command;

class HasPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:has {username} {pattern}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if a user has a permission.';

    /**
     * @var App\Contracts\Auth\UserRepository
     */
    protected $users;

    /**
     * Create a new command instance.
     */
    public function __construct(UserRepository $users)
    {
        parent::__construct();

        $this->users = $users;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = $this->getUser();
        if ($user === null) {
            $this->error("That user does not exist.");
            return;
        }

        $pattern = $this->argument('pattern');
        if ($user->hasPermission($pattern)) {
            $this->info("Yes");
        } else {
            $this->info("No");
        }
    }

    /**
     * Get the user from the command parameter.
     *
     * @return App\Auth\Models\User
     */
    private function getUser()
    {
        return $this->users->findByUsername($this->argument('username'));
    }
}
