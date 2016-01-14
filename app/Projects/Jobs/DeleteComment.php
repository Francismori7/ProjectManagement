<?php

namespace App\Projects\Jobs;

use App\Contracts\Projects\CommentRepository;
use App\Core\Jobs\Job;
use App\Projects\Models\Comment;

class DeleteComment extends Job
{
    /**
     * @var Comment
     */
    private $comment;

    /**
     * Create a new job instance.
     *
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     *
     * @param CommentRepository $comments
     *
     * @return array
     */
    public function handle(CommentRepository $comments)
    {
        $comments->delete($this->comment);

        return ['deleted' => true];
    }
}
