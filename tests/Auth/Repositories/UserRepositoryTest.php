<?php

namespace Tests\Auth\Repositories;

use App\Auth\Models\User;
use App\Contracts\Auth\UserRepository;
use DB;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var array
     */
    private $overrides;
    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var User
     */
    private $fakeUser;

    /**
     * Resolve our dependencies.
     */
    public function setUp()
    {
        parent::setUp();
        $this->users = $this->app->make(UserRepository::class);

        $this->overrides = ['username' => str_random(16)];
    }

    /**
     * Clean up test data.
     */
    public function tearDown()
    {
        $this->removeFakeUser();

        parent::tearDown();
    }

    /**
     * Removes the fake User.
     */
    protected function removeFakeUser()
    {
        if ($this->fakeUser) {
            $this->users->delete($this->fakeUser);
            $this->fakeUser = null;
        }
    }

    /**
     * @test
     */
    public function it_instantiates_itself_properly()
    {
        $this->assertNotNull($this->users);
    }

    /**
     * @test
     */
    public function all_method_returns_all_users_in_the_database()
    {
        factory(User::class)->times(10)->create();

        $userCount = DB::table('users')->count();

        $users = $this->users->findAll();

        $this->assertEquals(10, $userCount);
        $this->assertCount($userCount, $users);
    }

    /**
     * @test
     */
    public function find_by_uuid_returns_the_proper_user()
    {
        $this->createFakeUser();

        $foundUser = $this->users->findByUUID($this->fakeUser->id);

        $this->assertEquals($this->fakeUser->fresh(), $foundUser);
        $this->assertNotNull($foundUser);
    }

    /**
     * Create a fake user with the provided overrides, rest is generated by Faker.
     *
     * @return User
     */
    protected function createFakeUser()
    {
        $this->fakeUser = $this->users->create(
            factory(User::class)->make($this->overrides)
        );

        $this->seeInDatabase('users', $this->overrides);

        return $this->fakeUser;
    }

    /**
     * @test
     */
    public function find_by_username_returns_the_proper_user()
    {
        $this->createFakeUser();

        $foundUser = $this->users->findByUsername($this->fakeUser->username);

        $this->assertEquals($this->fakeUser->fresh(), $foundUser);
        $this->assertNotNull($foundUser);
    }

    /**
     * @test
     */
    public function find_by_email_returns_the_proper_user()
    {
        $this->createFakeUser();

        $foundUser = $this->users->findByEmail($this->fakeUser->email);

        $this->assertEquals($this->fakeUser->fresh(), $foundUser);
        $this->assertNotNull($foundUser);
    }

    /**
     * @test
     */
    public function it_properly_deletes_an_user()
    {
        $this->createFakeUser();

        $this->users->delete($this->fakeUser);
        $this->fakeUser = null;

        $this->notSeeInDatabase('users', $this->overrides + ['deleted_at' => null]);
    }

    /**
     * @test
     */
    public function find_methods_return_null_instead_of_throwing_exceptions_if_no_result_is_returned()
    {
        $user = $this->users->findByUsername(str_random(8));

        $this->assertNull($user);
    }
}
