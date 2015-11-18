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

    /**
     * @test
     */
    public function a_logged_out_user_cannot_update_the_completed_field_of_a_task()
    {
        $project = factory(Project::class)->create();
        $host = factory(User::class)->create();
        $task = factory(Task::class)->create([
            'project_id' => $project->id,
            'host_id' => $host->id,
            'completed' => false
        ]);

        $this->patch(route('api.v1.projects.tasks.complete', [$project->id, $task->id]), [], [
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $this->assertResponseStatus(403);
        $this->seeInDatabase('tasks', [
            'project_id' => $project->id,
            'host_id' => $host->id,
            'completed' => false
        ]);
    }

    /**
     * @test
     */
    public function a_logged_in_user_without_permission_cannot_update_the_completed_field_of_a_task()
    {
        $this->setUpPermissions();
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create();
        $project->users()->attach($user, ['role' => '']);
        $host = factory(User::class)->create();
        $task = factory(Task::class)->create([
            'project_id' => $project->id,
            'host_id' => $host->id,
            'completed' => false
        ]);
        $this->actingAs($user);

        $this->patch(route('api.v1.projects.tasks.complete', [$project->id, $task->id]), [], [
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $this->assertResponseStatus(403);
        $this->seeInDatabase('tasks', [
            'project_id' => $project->id,
            'host_id' => $host->id,
            'completed' => false
        ]);
    }

    /**
     * @test
     */
    public function a_logged_in_user_with_permission_but_not_in_group_cannot_update_the_completed_field_of_a_task()
    {
        $this->setUpPermissions();
        $user = factory(User::class)->create();
        $this->giveUserPermission($user, 'projects.task.complete');
        $project = factory(Project::class)->create();
        $host = factory(User::class)->create();
        $task = factory(Task::class)->create([
            'project_id' => $project->id,
            'host_id' => $host->id,
            'completed' => false
        ]);
        $this->actingAs($user);

        $this->patch(route('api.v1.projects.tasks.complete', [$project->id, $task->id]), [], [
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $this->assertResponseStatus(403);
        $this->seeInDatabase('tasks', [
            'project_id' => $project->id,
            'host_id' => $host->id,
            'completed' => false
        ]);
    }

    /**
     * @test
     */
    public function a_logged_in_user_with_permission_and_in_group_cannot_update_the_completed_field_of_a_task_if_it_is_not_assigned_to_him(
    ) {
        $this->setUpPermissions();
        $user = factory(User::class)->create();
        $this->giveUserPermission($user, 'projects.task.complete');
        $project = factory(Project::class)->create();
        $project->users()->attach($user, ['role' => '']);
        $host = factory(User::class)->create();
        $task = factory(Task::class)->create([
            'project_id' => $project->id,
            'host_id' => $host->id,
            'completed' => false
        ]);
        $this->actingAs($user);

        $this->patch(route('api.v1.projects.tasks.complete', [$project->id, $task->id]), [], [
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $this->assertResponseStatus(403);
        $this->seeInDatabase('tasks', [
            'project_id' => $project->id,
            'host_id' => $host->id,
            'completed' => false
        ]);
    }

    /**
     * @test
     */
    public function a_user_with_permission_and_in_group_can_update_the_completed_field_of_a_task_if_it_is_assigned_to_him()
    {
        $this->setUpPermissions();
        $user = factory(User::class)->create();
        $this->giveUserPermission($user, 'projects.task.complete');
        $project = factory(Project::class)->create();
        $project->users()->attach($user, ['role' => '']);
        $host = factory(User::class)->create();
        $task = factory(Task::class)->create([
            'project_id' => $project->id,
            'host_id' => $host->id,
            'employee_id' => $user->id,
            'completed' => false
        ]);
        $this->actingAs($user);

        $this->patch(route('api.v1.projects.tasks.complete', [$project->id, $task->id]), [], [
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $this->assertResponseOk();
        $this->seeJsonContains(['id' => $task->id, 'completed' => true]);
        $this->seeInDatabase('tasks', [
            'project_id' => $project->id,
            'host_id' => $host->id,
            'employee_id' => $user->id,
            'completed' => true
        ]);
    }

    /**
     * @test
     */
    public function a_project_leader_with_permission_can_update_the_completed_field_of_a_task()
    {
        $this->setUpPermissions();
        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();
        $this->giveUserPermission($user, 'projects.task.complete');
        $project = factory(Project::class)->create();
        $project->users()->attach($user, ['role' => 'leader']);
        $project->users()->attach($otherUser, ['role' => '']);
        $employee = factory(User::class)->create();
        $task = factory(Task::class)->create([
            'project_id' => $project->id,
            'host_id' => $otherUser->id,
            'employee_id' => $employee->id,
            'completed' => false
        ]);
        $this->actingAs($user);

        $this->patch(route('api.v1.projects.tasks.complete', [$project->id, $task->id]), [], [
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $this->assertResponseOk();
        $this->seeJsonContains(['id' => $task->id, 'completed' => true]);
        $this->seeInDatabase('tasks', [
            'project_id' => $project->id,
            'host_id' => $otherUser->id,
            'employee_id' => $employee->id,
            'completed' => true
        ]);
    }

    /**
     * @test
     */
    public function a_project_leader_with_permission_can_delete_a_task()
    {
        $this->setUpPermissions();
        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();
        $this->giveUserPermission($user, 'projects.task.destroy');
        $project = factory(Project::class)->create();
        $project->users()->attach($user, ['role' => 'leader']);
        $project->users()->attach($otherUser, ['role' => '']);
        $employee = factory(User::class)->create();
        $task = factory(Task::class)->create([
            'project_id' => $project->id,
            'host_id' => $otherUser->id,
            'employee_id' => $employee->id
        ]);
        $this->actingAs($user);

        $this->delete(route('api.v1.projects.tasks.destroy', [$project->id, $task->id]), [], [
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $this->assertResponseOk();
        $this->seeJsonContains(['deleted' => true]);
        $count = \DB::table('tasks')->where('id', $task->id)->whereNotNull('deleted_at')->count();
        $this->assertEquals(1, $count);
    }

    /**
     * @test
     */
    public function a_user_with_permission_cannot_delete_a_task()
    {
        $this->setUpPermissions();
        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();
        $this->giveUserPermission($user, 'projects.task.destroy');
        $project = factory(Project::class)->create();
        $project->users()->attach($user, ['role' => '']);
        $project->users()->attach($otherUser, ['role' => '']);
        $employee = factory(User::class)->create();
        $task = factory(Task::class)->create([
            'project_id' => $project->id,
            'host_id' => $otherUser->id,
            'employee_id' => $employee->id
        ]);
        $this->actingAs($user);

        $this->delete(route('api.v1.projects.tasks.destroy', [$project->id, $task->id]), [], [
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $this->assertResponseStatus(403);
        $count = \DB::table('tasks')->where('id', $task->id)->whereNull('deleted_at')->count();
        $this->assertEquals(1, $count);
    }
}
