<?php

namespace App\Employees\Controllers\Api\v1;

use App\Auth\Models\User;
use App\Contracts\Auth\UserRepository;
use App\Core\Controllers\Controller;

class EmployeeController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $users;

    /**
     * ProjectController constructor.
     *
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;

        $this->middleware('jwt.auth');
        $this->middleware('jwt.refresh', ['only' => 'store']);
    }

    /**
     * Returns the project's data.
     *
     * GET /api/v1/employees/{employee}
     *
     * @param $employee
     * @return User|null
     */
    public function show($employee)
    {
        return $this->users->findByUUID($employee, ['projects', 'tasks']);
    }
}
