<?php

namespace Test\Projects\Functional;

use App\Auth\Models\User;
use App\Projects\Models\Project;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    /**
     * @test
     */
    public function a_project_user_can_add_a_new_task() {
    }
}
