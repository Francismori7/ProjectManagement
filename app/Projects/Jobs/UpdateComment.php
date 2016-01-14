<?php

namespace App\Projects\Jobs;

use App\Contracts\Projects\CommentRepository;
use App\Core\Jobs\Job;
use App\Projects\Models\Comment;

class UpdateComment extends Job
{
    /**
     * @var Comment
     */
    private $comment;
    /**
     * @var array
     */
    private $data;

    /**
     * Create a new job instance.
     *
     * @param Comment $task
     * @param array $data
     */
    public function __construct(Comment $task, $data)
    {
        $this->comment = $task;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @param CommentRepository $comments
     * @return Comment
     */
    public function handle(CommentRepository $comments)
    {
        $this->comment->fill($this->data);

        $comments->save($this->comment);

        return $this->comment;
    }
}
