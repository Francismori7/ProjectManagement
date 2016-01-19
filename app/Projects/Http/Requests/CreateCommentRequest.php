<?php

namespace App\Projects\Http\Requests;

use App\Contracts\Projects\ProjectRepository;
use App\Core\Requests\Request;

class CreateCommentRequest extends Request
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

        if (!$this->user()->hasPermission('projects.comment.create')) {
            return false;
        }

        $project = $this->route('project')->load(['users']);

        /*
         * The project is deleted. Keep everything as it is.
         */
        if ($project->deleted_at) {
            return false;
        }

        /*
         * Can the user create a comment? (ie: is he part of the group?)
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
            'body' => 'required|min:10',
        ];
    }
}
