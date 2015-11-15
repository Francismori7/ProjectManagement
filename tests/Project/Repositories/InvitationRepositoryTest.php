<?php

namespace Tests\Auth\Repositories;

use App\Contracts\Projects\InvitationRepository;
use App\Contracts\Projects\ProjectRepository;
use App\Projects\Models\Project;
use App\Projects\Models\Invitation;
use DB;
use Faker\Factory;
use Tests\TestCase;

class InvitationRepositoryTest extends TestCase
{
    /**
     * @var array
     */
    private $overrides;
    /**
     * @var array
     */
    private $overridesProject;
    /**
     * @var InvitationRepository
     */
    private $invitations;
    /**
     * @var ProjectRepository
     */
    private $projects;
    /**
     * @var Invitation
     */
    private $fakeInvitation;
    /**
     * @var Project
     */
    private $fakeProject;

    /**
     * Resolve our dependencies.
     */
    public function setUp()
    {
        parent::setUp();
        $this->invitations = $this->app->make(InvitationRepository::class);
        $this->projects = $this->app->make(ProjectRepository::class);

        $this->overrides = ['email' => str_random(10) . '@test-email.tld'];
    }

    /**
     * Clean up test data.
     */
    public function tearDown()
    {
        $this->removeFakeInvitation();
        $this->removeFakeProject();

        parent::tearDown();
    }

    /**
     * Removes the fake Invitation.
     */
    protected function removeFakeInvitation()
    {
        if ($this->fakeInvitation) {
            $this->invitations->delete($this->fakeInvitation);
            $this->fakeInvitation = null;
        }
    }

    /**
     * Removes the fake Project.
     */
    protected function removeFakeProject()
    {
        if ($this->fakeProject) {
            $this->projects->delete($this->fakeProject);
            $this->fakeProject = null;
        }
    }

    /**
     * @test
     */
    public function it_instantiates_itself_properly()
    {
        $this->assertNotNull($this->invitations);
    }

    /**
     * @test
     */
    public function all_method_returns_all_invitations_in_the_database()
    {
        $invitationCount = DB::table('invitations')->count();

        $invitations = $this->invitations->findAll();
        $this->assertCount($invitationCount, $invitations);
    }

    /**
     * @test
     */
    public function find_by_uuid_returns_the_proper_invitation()
    {
        $this->createFakeInvitation();

        $foundInvitation = $this->invitations->findByUUID($this->fakeInvitation->id);

        $this->assertEquals($this->fakeInvitation->fresh(), $foundInvitation);
        $this->assertNotNull($foundInvitation);
    }

    /**
     * Create a fake invitation with the provided overrides, rest is generated by Faker.
     *
     * @return Invitation
     */
    protected function createFakeInvitation()
    {
        $this->fakeInvitation = $this->invitations->create(
            factory(Invitation::class)->make($this->overrides)
        );

        $this->fakeProject = $this->fakeInvitation->project;

        $this->seeInDatabase('invitations', $this->overrides);

        return $this->fakeInvitation;
    }

    /**
     * @test
     */
    public function it_properly_deletes_an_invitation_but_not_the_project_itself()
    {
        $this->createFakeInvitation();

        $this->invitations->delete($this->fakeInvitation);
        $this->fakeInvitation = null;

        $this->notSeeInDatabase('invitations', $this->overrides);
        $this->seeInDatabase('projects', ['id' => $this->fakeProject->id]);
    }

    /**
     * @test
     */
    public function deleting_all_invitations_for_a_project_does_not_delete_the_project_itself()
    {
        $this->fakeProject = factory(Project::class)->create();
        $invitations = factory(Invitation::class)->times(5)->create(['project_id' => $this->fakeProject->id]);

        $this->assertCount(5, $this->invitations->findByProject($this->fakeProject));

        foreach ($invitations as $invitation) {
            $this->invitations->delete($invitation);
            $this->notSeeInDatabase('invitations', ['id' => $invitation->id]);
        }

        $this->seeInDatabase('projects', ['id' => $this->fakeProject->id]);
    }

    /**
     * @test
     */
    public function find_methods_return_null_instead_of_throwing_exceptions_if_no_result_is_returned()
    {
        $project = $this->projects->find(str_random(36));

        $this->assertNull($project);
    }
}
