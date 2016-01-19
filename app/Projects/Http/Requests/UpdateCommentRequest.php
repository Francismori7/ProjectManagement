<?php

namespace App\Projects\Http\Requests;

use App\Contracts\Projects\ProjectRepository;
use App\Contracts\Projects\TaskRepository;
use App\Core\Requests\Request;

class UpdateCommentRequest extends Request
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

        if (! $this->user()->hasPermission('projects.comment.update')) {
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
         * Can the user update the comment (is he part of the project?)
         */
        if (! $project->users->contains('id', $this->user()->id)) {
            return false;
        }

        /*
         * Can the user update the comment? (is he the creator of the cmment?)
         */
        $comment = $this->route('comment');

        if ($comment->user_id === $this->user()->id) {
            return true;
        }

        /*
         * Can the user update the comment (is he a leader of the project?)
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
        return [
            'body' => 'required|min:10',
        ];
    }
}
