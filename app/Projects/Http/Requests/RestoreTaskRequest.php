<?php

namespace App\Projects\Http\Requests;

use App\Contracts\Projects\ProjectRepository;
use App\Core\Requests\Request;
use App\Projects\Models\Project;

class RestoreTaskRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (! $this->user()) {
            return false;
        }

        if (! $this->user()->hasPermission('projects.task.restore')) {
            return false;
        }

        /*
         * Can the user restore the task (ie: is he a project leader?)
         */
        $project = $this->route('project')->load(['users']);

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
