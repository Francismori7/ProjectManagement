<?php

namespace Test\Projects\Functional;

use App\Auth\Models\User;
use App\Projects\Models\Project;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    protected $overrides;

    use DatabaseTransactions, WithoutMiddleware;

    /**
     * Set up or tests' data.
     */
    public function setUp()
    {
        parent::setUp();

        $this->overrides = ['name' => 'Test project'];
    }

    /**
     * @test
     */
    public function a_logged_out_user_cannot_create_new_projects()
    {
        $this->post(route('api.v1.projects.store'), $this->overrides)->assertResponseStatus(403);

        $this->notSeeInDatabase('projects', $this->overrides);
    }

    /**
     * @test
     */
    public function a_logged_in_user_may_not_create_new_projects()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->post(route('api.v1.projects.store'), $this->overrides)->assertResponseStatus(403);

        $this->notSeeInDatabase('projects', $this->overrides);
    }

    /**
     * @test
     */
    public function a_logged_in_user_with_required_permission_may_create_new_projects()
    {
        $this->setUpPermissions();
        $user = factory(User::class)->create();
        $this->giveUserPermission($user, 'projects.project.create');
        $this->actingAs($user);

        $this->post(route('api.v1.projects.store'), $this->overrides)->assertResponseStatus(200);

        $this->seeJsonContains($this->overrides);
        $this->seeInDatabase('projects', $this->overrides);
    }

    /**
     * Installs the permissions.
     */
    protected function setUpPermissions()
    {
        $this->artisan('permissions:install');
    }

    /**
     * Gives permissions to a test user.
     *
     * @param User $user
     * @param array|string $patterns
     */
    protected function giveUserPermission(User $user, $patterns)
    {
        if (is_array($patterns)) {
            foreach ($patterns as $pattern) {
                $this->artisan('permissions:give', ['username' => $user->username, 'pattern' => $pattern]);
            }
            return;
        }
        $this->artisan('permissions:give', ['username' => $user->username, 'pattern' => $patterns]);
    }

    /**
     * @test
     */
    public function a_project_leader_can_delete_their_own_project()
    {
        $this->setUpPermissions();
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create([
            'created_by' => $user->id
        ]);
        $this->giveUserPermission($user, 'projects.project.destroy');
        $this->actingAs($user);

        $this->delete(route('api.v1.projects.destroy', [$project->id]))->assertResponseOk();

        $this->seeJsonEquals(['deleted' => true]);
        $count = \DB::table('projects')->where('id', $project->id)->whereNotNull('deleted_at')->count();
        $this->assertEquals(1, $count);
    }

    /**
     * @test
     */
    public function a_logged_in_user_without_permission_cannot_delete_a_project()
    {
        $this->setUpPermissions();
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create();
        $this->actingAs($user);

        $this->delete(route('api.v1.projects.destroy', [$project->id]))->assertResponseStatus(403);
    }

    /**
     * @test
     */
    public function a_logged_out_user_cannot_delete_a_project()
    {
        $project = factory(Project::class)->create();

        $this->delete(route('api.v1.projects.destroy', [$project->id]))->assertResponseStatus(403);
    }

    /**
     * @test
     */
    public function a_user_can_only_see_projects_he_is_part_of()
    {
        $user = factory(User::class)->create();
        $projects = factory(Project::class)->times(2)->create();
        /** @var Project $project */
        $project = factory(Project::class)->create();
        $project->users()->attach($user, ['role' => '']);
        $this->actingAs($user);

        $this->get(route('api.v1.projects.index'));

        $this->seeJsonContains(['id' => $project->id]);

        foreach ($projects as $dontSeeProject) {
            $this->dontSeeJson(['id' => $dontSeeProject->id]);
        }
    }

    /**
     * @test
     */
    public function a_user_can_only_request_info_on_a_project_he_is_part_of()
    {
        $user = factory(User::class)->create();
        $projects = factory(Project::class)->times(2)->create();
        /** @var Project $project */
        $project = factory(Project::class)->create();
        $project->users()->attach($user, ['role' => '']);
        $this->actingAs($user);

        $this->get(route('api.v1.projects.show', [$project->id]));

        $this->seeJsonContains(['id' => $project->id]);

        foreach ($projects as $dontSeeProject) {
            $this->get(route('api.v1.projects.show', [$dontSeeProject->id]));
            $this->seeJson(['not_in_project']);
            $this->assertResponseStatus(403);
        }
    }

    /**
     * @test
     */
    public function a_project_leader_can_update_a_project()
    {
        $this->setUpPermissions();
        $user = factory(User::class)->create();
        $this->giveUserPermission($user, 'projects.project.update');
        /** @var Project $project */
        $project = factory(Project::class)->create();
        $project->users()->attach($user, ['role' => 'leader']);
        $this->actingAs($user);

        $this->patch(route('api.v1.projects.update', [$project->id]), ['name' => 'New name']);

        $this->assertResponseOk();
        $this->seeJsonContains([
            'id' => $project->id,
            'name' => 'New name'
        ]);
    }

    /**
     * @test
     */
    public function a_project_user_cannot_update_a_project()
    {
        $this->setUpPermissions();
        $user = factory(User::class)->create();
        /** @var Project $project */
        $project = factory(Project::class)->create();
        $project->users()->attach($user, ['role' => '']);
        $this->actingAs($user);

        $this->patch(route('api.v1.projects.update', [$project->id]), ['name' => 'New name']);

        $this->assertResponseStatus(403);
        $this->notSeeInDatabase('projects', ['name' => 'New name']);
    }
}
