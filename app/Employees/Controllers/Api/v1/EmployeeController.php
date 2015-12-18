<?php

namespace App\Employees\Controllers\Api\v1;

use App\Auth\Models\User;
use App\Contracts\Auth\UserRepository;
use App\Core\Controllers\Controller;

class EmployeeController extends Controller
{
    /**
     * ProjectController constructor.
     */
    public function __construct()
    {
        $this->middleware('jwt.auth');
        $this->middleware('jwt.refresh', ['only' => 'store']);
    }

    /**
     * Returns the project's data.
     *
     * GET /api/v1/employees/{employee}
     *
     * @param User $employee
     * @return User|null
     */
    public function show(User $employee)
    {
        return $employee->load(['projects', 'tasks']);
    }
}
