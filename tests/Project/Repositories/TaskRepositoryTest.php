<?php

namespace Tests\Auth\Repositories;

use App\Auth\Models\User;
use App\Contracts\Projects\TaskRepository;
use App\Projects\Models\Project;
use App\Projects\Models\Task;
use DB;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TaskRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var array
     */
    private $overrides;
    /**
     * @var TaskRepository
     */
    private $tasks;
    /**
     * @var Task
     */
    private $fakeTask;

    /**
     * Resolve our dependencies.
     */
    public function setUp()
    {
        parent::setUp();
        $this->tasks = $this->app->make(TaskRepository::class);

        $this->overrides = ['task' => str_random(20)];
    }

    /**
     * Clean up test data.
     */
    public function tearDown()
    {
        $this->removeFakeTask();

        parent::tearDown();
    }

    /**
     * Removes the fake Task.
     */
    protected function removeFakeTask()
    {
        if ($this->fakeTask) {
            $this->tasks->delete($this->fakeTask);
            $this->fakeTask = null;
        }
    }

    /**
     * @test
     */
    public function it_instantiates_itself_properly()
    {
        $this->assertNotNull($this->tasks);
    }

    /**
     * @test
     */
    public function all_method_returns_all_tasks_in_the_database()
    {
        factory(Task::class)->times(10)->create();

        $taskCount = DB::table('tasks')->count();

        $tasks = $this->tasks->findAll();

        $this->assertEquals(10, $taskCount);
        $this->assertCount($taskCount, $tasks);
    }

    /**
     * @test
     */
    public function find_by_uuid_returns_the_proper_task()
    {
        $this->createFakeTask();

        $foundTask = $this->tasks->findByUUID($this->fakeTask->id);

        $this->assertEquals($this->fakeTask->fresh(), $foundTask);
        $this->assertNotNull($foundTask);
    }

    /**
     * Create a fake project with the provided overrides, rest is generated by Faker.
     *
     * @return Project
     */
    protected function createFakeTask()
    {
        $this->fakeTask = $this->tasks->create(
            factory(Task::class)->make($this->overrides)
        );

        $this->seeInDatabase('tasks', $this->overrides);

        return $this->fakeTask;
    }

    /**
     * @test
     */
    public function find_by_employee_returns_the_proper_task_list()
    {
        factory(Task::class)->create();

        $employee = factory(User::class)->create();
        factory(Task::class)->times(2)->create([
            'employee_id' => $employee->id
        ]);

        $tasks = $this->tasks->findByEmployee($employee);

        $this->assertCount(2, $tasks);
        $tasks->each(function (Task $task) use ($employee) {
            $this->assertEquals($employee->id, $task->employee_id);
        });
    }

    /**
     * @test
     */
    public function find_by_host_returns_the_proper_task_list()
    {
        factory(Task::class)->create();

        $host = factory(User::class)->create();
        factory(Task::class)->times(2)->create([
            'host_id' => $host->id
        ]);

        $tasks = $this->tasks->findByHost($host);

        $this->assertCount(2, $tasks);
        $tasks->each(function (Task $task) use ($host) {
            $this->assertEquals($host->id, $task->host_id);
        });
    }

    /**
     * @test
     */
    public function find_by_project_returns_the_proper_task_list()
    {
        factory(Task::class)->create();

        $project = factory(Project::class)->create();
        factory(Task::class)->times(2)->create([
            'project_id' => $project->id
        ]);

        $tasks = $this->tasks->findByProject($project);

        $this->assertCount(2, $tasks);
        $tasks->each(function (Task $task) use ($project) {
            $this->assertEquals($project->id, $task->project_id);
        });
    }

    /**
     * @test
     */
    public function it_properly_deletes_a_task()
    {
        $this->createFakeTask();

        $this->tasks->delete($this->fakeTask);
        $this->fakeTask = null;

        $this->notSeeInDatabase('tasks', $this->overrides + ['deleted_at' => null]);
    }

    /**
     * @test
     */
    public function find_methods_return_null_instead_of_throwing_exceptions_if_no_result_is_returned()
    {
        $task = $this->tasks->find(str_random(36));

        $this->assertNull($task);
    }
}
