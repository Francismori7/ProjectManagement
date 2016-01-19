<?php

namespace App\Projects\Controllers\Api\v1;

use App\Contracts\Projects\CommentRepository;
use App\Core\Controllers\Controller;
use App\Projects\Exceptions\UserNotInProjectException;
use App\Projects\Http\Requests\CreateCommentRequest;
use App\Projects\Http\Requests\DeleteCommentRequest;
use App\Projects\Http\Requests\DeleteTaskRequest;
use App\Projects\Http\Requests\RestoreTaskRequest;
use App\Projects\Http\Requests\UpdateCommentRequest;
use App\Projects\Jobs\CreateNewComment;
use App\Projects\Jobs\DeleteComment;
use App\Projects\Jobs\RestoreComment;
use App\Projects\Jobs\UpdateComment;
use App\Projects\Models\Comment;
use App\Projects\Models\Project;

class ProjectCommentController extends Controller
{
    /**
     * @var CommentRepository
     */
    protected $comments;

    /**
     * ProjectTaskController constructor.
     *
     * @param CommentRepository $comments
     */
    public function __construct(CommentRepository $comments)
    {
        $this->middleware('jwt.auth');
        $this->middleware('jwt.refresh', ['only' => 'store']);
        $this->comments = $comments;
    }

    /**
     * Gets a list of comments.
     *
     * GET /api/v1/projects/{project}/comments
     *
     * @param Project $project
     * @return array
     */
    public function index(Project $project)
    {
        if (!auth()->user()->projects->contains('id', $project->id)) {
            throw new UserNotInProjectException();
        }

        $project->load('comments');

        return [
            'comments' => $project->comments,
        ];
    }

    /**
     * Returns the comment's data.
     *
     * GET /api/v1/projects/{project}/comments/{comment}
     *
     * @param Project $project
     * @param Comment $comment
     * @return Comment|null
     */
    public function show(Project $project, Comment $comment)
    {
        if (!auth()->user()->projects->contains('id', $project->id)) {
            throw new UserNotInProjectException();
        }

        return $comment->load(['user', 'project']);
    }

    /**
     * Deletes a comment.
     *
     * DELETE /api/v1/projects/{project}/comments/{comment}
     *
     * @param Project $project
     * @param Comment $comment
     * @param DeleteCommentRequest $request
     * @return array
     */
    public function destroy(Project $project, Comment $comment, DeleteCommentRequest $request)
    {
        return $this->dispatch(new DeleteComment(
            $comment
        ));
    }

    /**
     * Restores a comment.
     *
     * PATCH /api/v1/projects/{project}/comments/{comment}/restore
     *
     * @param Project $project
     * @param Comment $comment
     * @param RestoreTaskRequest $request
     * @return array
     */
    public function restore(Project $project, Comment $comment, RestoreTaskRequest $request)
    {
        return $this->dispatch(new RestoreComment(
            $comment
        ));
    }

    /**
     * Creates a new comment for the given project.
     *
     * POST /api/v1/projects/{project}/comments (body)
     *
     * @param Project $project
     * @param CreateCommentRequest $request
     * @return array
     */
    public function store(Project $project, CreateCommentRequest $request)
    {
        return $this->dispatch(
            new CreateNewComment($request->all(), $project, $request->user())
        );
    }

    /**
     * Updates a comment.
     *
     * PATCH /api/v1/projects/{project}/comments/{comment} (body)
     *
     * @param Project $project
     * @param Comment $comment
     * @param UpdateCommentRequest $request
     * @return array
     */
    public function update(Project $project, Comment $comment, UpdateCommentRequest $request)
    {
        return $this->dispatch(
            new UpdateComment($comment, $request->all())
        );
    }
}
