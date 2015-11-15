<?php

namespace App\Projects\Http\Requests;

use App\Contracts\Auth\UserRepository;
use App\Contracts\Projects\ProjectRepository;
use App\Core\Requests\Request;
use App\Projects\Models\Project;

class PromoteUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!$this->user()) {
            return false;
        }

        if (!$this->user()->hasPermission('projects.project.promote_user')) {
            return false;
        }

        $projects = app()->make(ProjectRepository::class);
        $project = $projects->findByUUID($this->route('project'), ['users']);

        /*
         * Can the user promote another user? (ie: is he the project creator?)
         */
        if($project->creator->id !== $this->user()->id) {
            return false;
        }

        $users = app()->make(UserRepository::class);
        $user = $users->findByUUID($this->route('user'));

        /*
         * We cannot promote a user if he's not in the project's users.
         */
        if (!$project->users->contains('id', $user->id)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
