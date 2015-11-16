<?php

namespace App\Projects\Http\Requests;

use App\Contracts\Projects\ProjectRepository;
use App\Core\Requests\Request;

class CreateTaskRequest extends Request
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

        if (!$this->user()->hasPermission('projects.task.create')) {
            return false;
        }

        $projects = app()->make(ProjectRepository::class);
        $project = $projects->findByUUID($this->route('project'), ['users']);

        /*
         * Can the user create a task? (ie: is he part of the group?)
         */
        if (!$project->users->contains('id', $this->user()->id)) {
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
            'name' => 'required|min:3|max:100',
            'due_at' => 'date',
        ];
    }
}
