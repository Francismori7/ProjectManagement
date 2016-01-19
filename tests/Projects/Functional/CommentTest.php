<?php

namespace Test\Projects\Functional;

use App\Auth\Models\User;
use App\Projects\Models\Comment;
use App\Projects\Models\Project;
use App\Projects\Models\Task;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    /**
     * @test
     */
    public function a_project_user_can_add_a_new_comment()
    {
        $this->setUpPermissions();
        $project = factory(Project::class)->create();
        $user = factory(User::class)->create();
        $this->giveUserPermission($user, 'projects.comment.create');
        $project->users()->attach($user, ['role' => '']);
        $this->actingAs($user);

        $this->post(route('api.v1.projects.comments.store', [$project->id]), [
            'body' => 'New comment'
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $this->assertResponseOk();
        $this->seeJson();

        $this->seeInDatabase('comments', [
            'project_id' => $project->id,
            'user_id' => $user->id,
            'body' => 'New comment'
        ]);
    }

    /**
     * @test
     */
    public function a_user_not_in_a_project_cannot_add_a_new_comment()
    {
        $this->setUpPermissions();
        $project = factory(Project::class)->create();
        $user = factory(User::class)->create();
        $this->giveUserPermission($user, 'projects.comment.create');
        $this->actingAs($user);

        $this->post(route('api.v1.projects.comments.store', [$project->id]), [
            'body' => 'New comment'
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $this->assertResponseStatus(403);

        $this->notSeeInDatabase('comments', [
            'project_id' => $project->id,
            'user_id' => $user->id,
            'body' => 'New comment'
        ]);
    }

    /**
     * @test
     */
    public function a_user_in_a_project_without_permission_cannot_add_a_new_comment()
    {
        $this->setUpPermissions();
        $project = factory(Project::class)->create();
        $user = factory(User::class)->create();
        $project->users()->attach($user, ['role' => '']);
        $this->actingAs($user);

        $this->post(route('api.v1.projects.comments.store', [$project->id]), [
            'body' => 'New comment'
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $this->assertResponseStatus(403);

        $this->notSeeInDatabase('comments', [
            'project_id' => $project->id,
            'user_id' => $user->id,
            'body' => 'New comment'
        ]);
    }

    /**
     * @test
     */
    public function a_user_not_in_a_project_cannot_see_its_comments()
    {
        $this->setUpPermissions();
        $project = factory(Project::class)->create();
        $comments = factory(Comment::class)->times(2)->create(['project_id' => $project->id]);
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->get(route('api.v1.projects.comments.index', [$project->id]), ['X-Requested-With' => 'XMLHttpRequest']);

        $this->assertResponseStatus(403);
        $this->seeJson();
        $this->dontSeeJson($comments->toArray());
    }

    /**
     * @test
     */
    public function a_user_in_a_project_may_see_its_comments()
    {
        $this->setUpPermissions();
        $project = factory(Project::class)->create();
        $comments = factory(Comment::class)->times(2)->create(['project_id' => $project->id]);
        $user = factory(User::class)->create();
        $project->users()->attach($user, ['role' => '']);
        $this->actingAs($user);

        $this->get(route('api.v1.projects.comments.index', [$project->id]), ['X-Requested-With' => 'XMLHttpRequest']);

        $this->assertResponseOk();
        $this->seeJson();
        foreach ($comments as $comment) {
            $this->seeJsonContains(['id' => $comment->id]);
        }
    }

    /**
     * @test
     */
    public function a_user_in_a_project_may_not_update_a_comment()
    {
        $this->setUpPermissions();
        $project = factory(Project::class)->create();
        $comment = factory(Comment::class)->create(['project_id' => $project->id]);
        $user = factory(User::class)->create();
        $this->giveUserPermission($user, 'projects.comment.update');
        $project->users()->attach($user, ['role' => '']);
        $this->actingAs($user);

        $this->patch(route('api.v1.projects.comments.update', [$project->id, $comment->id]), [
            'body' => 'Updated comment'
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $this->assertResponseStatus(403);
        $this->dontSeeInDatabase('comments', [
            'id' => $comment->id,
            'body' => 'Updated comment'
        ]);
    }

    /**
     * @test
     */
    public function a_leader_in_a_project_may_update_a_comment()
    {
        $this->setUpPermissions();
        $project = factory(Project::class)->create();
        $comment = factory(Comment::class)->create(['project_id' => $project->id]);
        $user = factory(User::class)->create();
        $this->giveUserPermission($user, 'projects.comment.update');
        $project->users()->attach($user, ['role' => 'leader']);
        $this->actingAs($user);

        $this->patch(route('api.v1.projects.comments.update', [$project->id, $comment->id]), [
            'body' => 'Updated comment'
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $this->assertResponseOk();
        $this->seeInDatabase('comments', [
            'id' => $comment->id,
            'body' => 'Updated comment'
        ]);
    }

    /**
     * @test
     */
    public function a_user_not_in_a_project_may_not_update_a_comment()
    {
        $this->setUpPermissions();
        $project = factory(Project::class)->create();
        $comment = factory(Comment::class)->create(['project_id' => $project->id]);
        $user = factory(User::class)->create();
        $this->giveUserPermission($user, 'projects.comment.update');
        $this->actingAs($user);

        $this->patch(route('api.v1.projects.comments.update', [$project->id, $comment->id]), [
            'body' => 'Updated comment'
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $this->assertResponseStatus(403);
        $this->dontSeeInDatabase('comments', [
            'id' => $comment->id,
            'body' => 'Updated comment'
        ]);
    }

    /**
     * @test
     */
    public function the_creator_of_a_comment_may_update_the_comment()
    {
        $this->setUpPermissions();
        $project = factory(Project::class)->create();
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create(['project_id' => $project->id, 'user_id' => $user->id]);
        $this->giveUserPermission($user, 'projects.comment.update');
        $project->users()->attach($user, ['role' => '']);
        $this->actingAs($user);

        $this->patch(route('api.v1.projects.comments.update', [$project->id, $comment->id]), [
            'body' => 'Updated comment'
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $this->assertResponseOk();
        $this->seeInDatabase('comments', [
            'id' => $comment->id,
            'body' => 'Updated comment'
        ]);
    }
    /**
     * @test
     */
    public function a_project_leader_with_permission_can_delete_a_comment()
    {
        $this->setUpPermissions();
        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();
        $this->giveUserPermission($user, 'projects.comment.destroy');
        $project = factory(Project::class)->create();
        $project->users()->attach($user, ['role' => 'leader']);
        $project->users()->attach($otherUser, ['role' => '']);
        $comment = factory(Comment::class)->create([
            'project_id' => $project->id,
            'user_id' => $otherUser->id,
        ]);
        $this->actingAs($user);

        $this->delete(route('api.v1.projects.comments.destroy', [$project->id, $comment->id]), [], [
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $this->assertResponseOk();
        $this->seeJsonContains(['deleted' => true]);
        $count = \DB::table('comments')->where('id', $comment->id)->whereNotNull('deleted_at')->count();
        $this->assertEquals(1, $count);
    }

    /**
     * @test
     */
    public function a_user_with_permission_cannot_delete_a_comment()
    {
        $this->setUpPermissions();
        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();
        $this->giveUserPermission($user, 'projects.comment.destroy');
        $project = factory(Project::class)->create();
        $project->users()->attach($user, ['role' => '']);
        $project->users()->attach($otherUser, ['role' => '']);
        $comment = factory(Comment::class)->create([
            'project_id' => $project->id,
            'user_id' => $otherUser->id,
        ]);
        $this->actingAs($user);

        $this->delete(route('api.v1.projects.comments.destroy', [$project->id, $comment->id]), [], [
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $this->assertResponseStatus(403);
        $count = \DB::table('comments')->where('id', $comment->id)->whereNull('deleted_at')->count();
        $this->assertEquals(1, $count);
    }
}
