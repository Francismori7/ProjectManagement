<?php

namespace Tests\Projects\Repositories;

use App\Contracts\Projects\ProjectRepository;
use App\Projects\Models\Project;
use DB;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProjectRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var array
     */
    private $overrides;
    /**
     * @var ProjectRepository
     */
    private $projects;
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
        $this->projects = $this->app->make(ProjectRepository::class);

        $this->overrides = ['name' => str_random(7) . ' ' . str_random(8)];
    }

    /**
     * Clean up test data.
     */
    public function tearDown()
    {
        $this->removeFakeProject();

        parent::tearDown();
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
        $this->assertNotNull($this->projects);
    }

    /**
     * @test
     */
    public function all_method_returns_all_projects_in_the_database()
    {
        factory(Project::class)->times(10)->create();

        $projectCount = DB::table('projects')->count();

        $projects = $this->projects->findAll();

        $this->assertEquals(10, $projectCount);
        $this->assertCount($projectCount, $projects);
    }

    /**
     * @test
     */
    public function find_by_uuid_returns_the_proper_project()
    {
        $this->createFakeProject();

        $foundProject = $this->projects->findByUUID($this->fakeProject->id);

        $this->assertEquals($this->fakeProject, $foundProject);
        $this->assertNotNull($foundProject);
    }

    /**
     * Create a fake project with the provided overrides, rest is generated by Faker.
     *
     * @return Project
     */
    protected function createFakeProject()
    {
        $this->fakeProject = $this->projects->create(
            factory(Project::class)->make($this->overrides)
        );

        $this->seeInDatabase('projects', $this->overrides);

        return $this->fakeProject;
    }

    /**
     * @test
     */
    public function it_properly_deletes_a_project()
    {
        $this->createFakeProject();

        $this->projects->delete($this->fakeProject);
        $this->fakeProject = null;

        $this->notSeeInDatabase('projects', $this->overrides + ['deleted_at' => null]);
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
