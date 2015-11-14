<?php

namespace App\Projects\Http\Requests;

use App\Contracts\Projects\ProjectRepository;
use App\Core\Requests\Request;
use App\Projects\Models\Project;

class DeleteProjectRequest extends Request
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

        if (!$this->user()->hasPermission('projects.project.destroy')) {
            return false;
        }

        /*
         * Can the user delete the project (ie: is he a leader?)
         */
        $projects = app()->make(ProjectRepository::class);

        $project = $projects->findByUUID($this->route('id'), ['users']);

        return $project->leaders->contains('id', $this->user()->id);
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
