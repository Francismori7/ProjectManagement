<?php

namespace Tests\Auth\Repositories;

use App\Contracts\Auth\UserRepository;
use Tests\TestCase;

class DoctrineUserRepositoryTest extends TestCase
{

    /**
     * @var UserRepository
     */
    private $users;

    /**
     * Resolve our dependencies.
     */
    public function setUp()
    {
        parent::setUp();
        $this->users = $this->app->make(UserRepository::class);
    }

    /**
     * @test
     */
    public function it_instanciates_itself_properly() {
        $this->assertNotNull($this->users);
    }

    // TODO: Empty - couldn't think of something right now.
}
