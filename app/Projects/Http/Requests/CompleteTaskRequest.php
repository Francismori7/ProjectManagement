<?php

namespace App\Projects\Http\Requests;

use App\Contracts\Projects\ProjectRepository;
use App\Contracts\Projects\TaskRepository;
use App\Core\Requests\Request;

class CompleteTaskRequest extends Request
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

        if (!$this->user()->hasPermission('projects.task.complete')) {
            return false;
        }

        /*
         * Can the user complete the task (is he part of the project?)
         */
        $project = $this->route('project')->load(['users']);

        if (!$project->users->contains('id', $this->user()->id)) {
            return false;
        }

        /*
         * The project is deleted. Keep everything as it is.
         */
        if ($project->deleted_at) {
            return false;
        }

        /*
         * Can the user update the task? (is he the creator of the task?)
         */
        $task = $this->route('task')->load(['host']);

        if ($task->host->id === $this->user()->id) {
            return true;
        }

        if ($task->employee->id === $this->user()->id) {
            return true;
        }

        /*
         * Can the user update the task (is he a leader of the project?)
         */
        if ($project->leaders->contains('id', $this->user()->id)) {
            return true;
        }

        return false;
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
