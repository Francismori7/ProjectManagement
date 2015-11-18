<?php

namespace App\Projects\Http\Requests;

use App\Contracts\Auth\UserRepository;
use App\Contracts\Projects\ProjectRepository;
use App\Core\Requests\Request;
use App\Projects\Models\Project;

class InviteUserRequest extends Request
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

        if (!$this->user()->hasPermission('projects.project.invite_user')) {
            return false;
        }

        $projects = app()->make(ProjectRepository::class);
        $project = $projects->findByUUID($this->route('project'), ['users']);

        /*
         * The project is deleted. Keep everything as it is.
         */
        if($project->deleted_at) {
            return false;
        }

        /*
         * Can the user invite another user? (ie: is he a project leader?)
         */
        if (!$project->leaders->contains('id', $this->user()->id)) {
            return false;
        }

        /*
         * The user whose email is getting invited is already part of this project.
         */
        if ($project->users->contains('email', $this->input('email'))) {
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
        return [
            'email' => 'required|email',
        ];
    }
}
