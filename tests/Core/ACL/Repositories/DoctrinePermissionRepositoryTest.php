<?php

namespace Core\ACL\Repositories;

use App\Contracts\ACL\PermissionRepository;
use App\Core\ACL\Models\Permission;
use DB;
use Doctrine\ORM\Mapping as ORM;
use Faker\Factory;
use Tests\TestCase;

class DoctrinePermissionRepositoryTest extends TestCase
{
    /**
     * @var array
     */
    private $overrides;
    /**
     * @var PermissionRepository
     */
    private $permissions;
    /**
     * @var Permission
     */
    private $fakePermission;

    /**
     * Resolve our dependencies.
     */
    public function setUp()
    {
        parent::setUp();
        $this->permissions = $this->app->make(PermissionRepository::class);

        $this->overrides = ['pattern' => 'test.permission.' . str_random(5)];
    }

    /**
     * @test
     */
    public function it_instantiates_itself_properly()
    {
        $this->assertNotNull($this->permissions);
    }

    /**
     * @test
     */
    public function all_method_returns_all_permissions_in_the_database()
    {
        $permissionCount = DB::table('permissions')->count();

        $permissions = $this->permissions->findAll();
        $this->assertCount($permissionCount, $permissions);
    }

    /**
     * @test
     */
    public function find_by_id_returns_the_proper_permission()
    {
        $this->createFakePermission();

        $foundPermission = $this->permissions->findByID($this->fakePermission->getId());

        $this->assertEquals($this->fakePermission, $foundPermission);
        $this->assertNotNull($foundPermission);

        $this->removeFakePermission();
    }

    /**
     * @test
     */
    public function find_by_pattern_returns_the_proper_permission()
    {
        $this->createFakePermission();

        $foundPermission = $this->permissions->findByPattern($this->fakePermission->getPattern());

        $this->assertEquals($this->fakePermission, $foundPermission);
        $this->assertNotNull($foundPermission);

        $this->removeFakePermission();
    }

    /**
     * @test
     */
    public function it_properly_deletes_a_permission()
    {
        $this->createFakePermission();

        $this->permissions->delete($this->fakePermission)->flush($this->fakePermission);
        $this->fakePermission = null;

        $permissions = $this->permissions->all();
        $this->assertNotContains($this->overrides, $permissions);
    }

    /**
     * @test
     */
    public function find_methods_return_null_instead_of_throwing_exceptions_if_no_result_is_returned()
    {
        $permission = $this->permissions->findByPattern(str_random(8));

        $this->assertNull($permission);
    }

    /**
     * Create a fake permission with the provided overrides, rest is generated by Faker.
     *
     * @return Permission
     */
    protected function createFakePermission()
    {
        $faker = Factory::create();

        $permissionAttributes = $this->overrides + [
                'name' => $faker->sentence(3),
                'pattern' => $faker->word . '.' . $faker->word . '.' . $faker->word,
            ];

        $this->fakePermission = (new Permission)->setName($permissionAttributes['name'])
            ->setPattern($permissionAttributes['pattern']);

        $this->permissions->create($this->fakePermission)->flush($this->fakePermission);

        $this->seeInDatabase('permissions', $this->overrides);

        return $this->fakePermission;
    }

    /**
     * Removes the fake Permission.
     */
    protected function removeFakePermission()
    {
        $this->permissions->delete($this->fakePermission)->flush($this->fakePermission);
        $this->fakePermission = null;
    }
}
