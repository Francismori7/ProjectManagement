<?php

namespace App\Projects\Jobs;

use App\Contracts\Projects\CommentRepository;
use App\Core\Jobs\Job;
use App\Projects\Models\Comment;

class RestoreComment extends Job
{
    /**
     * @var Comment
     */
    private $comment;

    /**
     * Execute the job.
     *
     * @param CommentRepository $comments
     *
     * @return Comment
     */
    public function handle(CommentRepository $comments)
    {
        $this->comment->restore();

        $comments->save($this->comment);

        return $this->comment->fresh();
    }

    /**
     * Create a new job instance.
     *
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
}
