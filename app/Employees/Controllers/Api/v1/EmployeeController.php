<?php

namespace App\Employees\Controllers\Api\v1;

use App\Auth\Models\User;
use App\Contracts\Auth\UserRepository;
use App\Contracts\Projects\ProjectRepository;
use App\Core\Controllers\Controller;
use App\Projects\Http\Requests\CreateProjectRequest;
use App\Projects\Http\Requests\DeleteProjectRequest;
use App\Projects\Http\Requests\UpdateProjectRequest;
use App\Projects\Jobs\CreateNewProject;
use App\Projects\Jobs\DeleteProject;
use App\Projects\Jobs\UpdateProject;
use App\Projects\Models\Project;

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
        $this->middleware('jwt.refresh');
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