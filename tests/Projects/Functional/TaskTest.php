<?php

namespace Test\Projects\Functional;

use App\Auth\Models\User;
use App\Projects\Models\Project;
use App\Projects\Models\Task;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    /**
     * @test
     */
    public function a_project_user_can_add_a_new_task()
    {
        $this->setUpPermissions();
        $project = factory(Project::class)->create();
        $user = factory(User::class)->create();
        $this->giveUserPermission($user, 'projects.task.create');
        $project->users()->attach($user, ['role' => '']);
        $this->actingAs($user);

        $this->post(route('api.v1.projects.tasks.store', [$project->id]), [
            'task' => 'New task'
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $this->assertResponseOk();
        $this->seeJson();

        $this->seeInDatabase('tasks', [
            'project_id' => $project->id,
            'host_id' => $user->id,
            'task' => 'New task'
        ]);
    }

    /**
     * @test
     */
    public function a_user_not_in_a_project_cannot_add_a_new_task()
    {
        $this->setUpPermissions();
        $project = factory(Project::class)->create();
        $user = factory(User::class)->create();
        $this->giveUserPermission($user, 'projects.task.create');
        $this->actingAs($user);

        $this->post(route('api.v1.projects.tasks.store', [$project->id]), [
            'task' => 'New task'
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $this->assertResponseStatus(403);

        $this->notSeeInDatabase('tasks', [
            'project_id' => $project->id,
            'host_id' => $user->id,
            'task' => 'New task'
        ]);
    }

    /**
     * @test
     */
    public function a_user_in_a_project_without_permission_cannot_add_a_new_task()
    {
        $this->setUpPermissions();
        $project = factory(Project::class)->create();
        $user = factory(User::class)->create();
        $project->users()->attach($user, ['role' => '']);
        $this->actingAs($user);

        $this->post(route('api.v1.projects.tasks.store', [$project->id]), [
            'task' => 'New task'
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $this->assertResponseStatus(403);

        $this->notSeeInDatabase('tasks', [
            'project_id' => $project->id,
            'host_id' => $user->id,
            'task' => 'New task'
        ]);
    }

    /**
     * @test
     */
    public function a_user_not_in_a_project_cannot_see_its_tasks()
    {
        $this->setUpPermissions();
        $project = factory(Project::class)->create();
        $tasks = factory(Task::class)->times(2)->create(['project_id' => $project->id]);
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->get(route('api.v1.projects.tasks.index', [$project->id]), ['X-Requested-With' => 'XMLHttpRequest']);

        $this->assertResponseStatus(403);
        $this->seeJson();
        $this->dontSeeJson($tasks->toArray());
    }

    /**
     * @test
     */
    public function a_user_in_a_project_may_see_its_tasks()
    {
        $this->setUpPermissions();
        $project = factory(Project::class)->create();
        $tasks = factory(Task::class)->times(2)->create(['project_id' => $project->id]);
        $user = factory(User::class)->create();
        $project->users()->attach($user, ['role' => '']);
        $this->actingAs($user);

        $this->get(route('api.v1.projects.tasks.index', [$project->id]), ['X-Requested-With' => 'XMLHttpRequest']);

        $this->assertResponseOk();
        $this->seeJson();
        foreach ($tasks as $task) {
            $this->seeJsonContains(['id' => $task->id]);
        }
    }

    /**
     * @test
     */
    public function a_user_in_a_project_may_not_update_a_task()
    {
        $this->setUpPermissions();
        $project = factory(Project::class)->create();
        $task = factory(Task::class)->create(['project_id' => $project->id]);
        $user = factory(User::class)->create();
        $this->giveUserPermission($user, 'projects.task.update');
        $project->users()->attach($user, ['role' => '']);
        $this->actingAs($user);

        $this->patch(route('api.v1.projects.tasks.update', [$project->id, $task->id]), [
            'task' => 'Updated task'
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $this->assertResponseStatus(403);
        $this->dontSeeInDatabase('tasks', [
            'id' => $task->id,
            'task' => 'Updated task'
        ]);
    }

    /**
     * @test
     */
    public function a_leader_in_a_project_may_update_a_task()
    {
        $this->setUpPermissions();
        $project = factory(Project::class)->create();
        $task = factory(Task::class)->create(['project_id' => $project->id]);
        $user = factory(User::class)->create();
        $this->giveUserPermission($user, 'projects.task.update');
        $project->users()->attach($user, ['role' => 'leader']);
        $this->actingAs($user);

        $this->patch(route('api.v1.projects.tasks.update', [$project->id, $task->id]), [
            'task' => 'Updated task'
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $this->assertResponseOk();
        $this->seeInDatabase('tasks', [
            'id' => $task->id,
            'task' => 'Updated task'
        ]);
    }

    /**
     * @test
     */
    public function a_user_not_in_a_project_may_not_update_a_task()
    {
        $this->setUpPermissions();
        $project = factory(Project::class)->create();
        $task = factory(Task::class)->create(['project_id' => $project->id]);
        $user = factory(User::class)->create();
        $this->giveUserPermission($user, 'projects.task.update');
        $this->actingAs($user);

        $this->patch(route('api.v1.projects.tasks.update', [$project->id, $task->id]), [
            'task' => 'Updated task'
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $this->assertResponseStatus(403);
        $this->dontSeeInDatabase('tasks', [
            'id' => $task->id,
            'task' => 'Updated task'
        ]);
    }

    /**
     * @test
     */
    public function the_host_of_a_task_may_update_the_task()
    {
        $this->setUpPermissions();
        $project = factory(Project::class)->create();
        $user = factory(User::class)->create();
        $task = factory(Task::class)->create(['project_id' => $project->id, 'host_id' => $user->id]);
        $this->giveUserPermission($user, 'projects.task.update');
        $project->users()->attach($user, ['role' => '']);
        $this->actingAs($user);

        $this->patch(route('api.v1.projects.tasks.update', [$project->id, $task->id]), [
            'task' => 'Updated task'
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $this->assertResponseOk();
        $this->seeInDatabase('tasks', [
            'id' => $task->id,
            'task' => 'Updated task'
        ]);
    }
}
