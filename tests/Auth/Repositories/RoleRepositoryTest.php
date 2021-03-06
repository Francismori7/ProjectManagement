<?php

namespace Tests\Auth\Repositories;

use App\Auth\Models\Role;
use App\Contracts\Auth\RoleRepository;
use DB;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Uuid;

class RoleRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var array
     */
    private $overrides;
    /**
     * @var RoleRepository
     */
    private $roles;
    /**
     * @var Role
     */
    private $fakeRole;

    /**
     * Resolve our dependencies.
     */
    public function setUp()
    {
        parent::setUp();
        $this->roles = $this->app->make(RoleRepository::class);

        $this->overrides = ['name' => str_random(16)];
    }

    /**
     * Clean up test data.
     */
    public function tearDown()
    {
        $this->removeFakeRole();

        parent::tearDown();
    }

    /**
     * Removes the fake Role.
     */
    protected function removeFakeRole()
    {
        if ($this->fakeRole) {
            $this->roles->delete($this->fakeRole);
            $this->fakeRole = null;
        }
    }

    /**
     * @test
     */
    public function it_instantiates_itself_properly()
    {
        $this->assertNotNull($this->roles);
    }

    /**
     * @test
     */
    public function all_method_returns_all_roles_in_the_database()
    {
        factory(Role::class)->times(10)->create();

        $roleCount = DB::table('roles')->count();

        $roles = $this->roles->findAll();

        $this->assertEquals(10, $roleCount);
        $this->assertCount($roleCount, $roles);
    }

    /**
     * @test
     */
    public function find_by_id_returns_the_proper_role()
    {
        $this->createFakeRole();

        $foundRole = $this->roles->findById($this->fakeRole->id);

        $this->assertEquals($this->fakeRole->fresh(), $foundRole);
        $this->assertNotNull($foundRole);
    }

    /**
     * Create a fake role with the provided overrides, rest is generated by Faker.
     *
     * @return Role
     */
    protected function createFakeRole()
    {
        $this->fakeRole = $this->roles->create(
            factory(Role::class)->make($this->overrides)
        );

        $this->seeInDatabase('roles', $this->overrides);

        return $this->fakeRole;
    }

    /**
     * @test
     */
    public function it_properly_deletes_a_role()
    {
        $this->createFakeRole();

        $this->roles->delete($this->fakeRole);
        $this->fakeRole = null;

        $this->notSeeInDatabase('roles', $this->overrides);
    }

    /**
     * @test
     */
    public function find_methods_return_null_instead_of_throwing_exceptions_if_no_result_is_returned()
    {
        $role = $this->roles->findById(Uuid::generate(4));

        $this->assertNull($role);
    }
}
