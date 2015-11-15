<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/


use App\Auth\Models\Role;
use App\Auth\Models\User;
use App\Core\ACL\Models\Permission;
use App\Projects\Models\Invitation;
use App\Projects\Models\Project;
use App\Projects\Models\Task;
use Faker\Generator;

/** @var $factory \Illuminate\Database\Eloquent\Factory */
$factory->define(User::class, function (Generator $faker) {
    return [
        'username' => $faker->userName,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password(8)),
    ];
});

$factory->define(Permission::class, function (Generator $faker) {
    return [
        'name' => $faker->sentence(3),
        'pattern' => $faker->word . '.' . $faker->word . '.' . $faker->word,
    ];
});

$factory->define(Role::class, function (Generator $faker) {
    return [
        'name' => $faker->sentence(3),
    ];
});

$factory->define(Project::class, function (Generator $faker) {
    $createdBy = factory(User::class)->create();
    return [
        'name' => $faker->sentence(3),
        'description' => $faker->text,
        'created_by' => $createdBy->id,
    ];
});

$factory->define(Invitation::class, function (Generator $faker) {
    $project = factory(Project::class)->create();
    $host = factory(User::class)->create();
    return [
        'project_id' => $project->id,
        'host_id' => $host->id,
        'email' => $faker->email,
    ];
});

$factory->define(Task::class, function (Generator $faker) {
    $project = factory(Project::class)->create();
    $employee = factory(User::class)->create();
    $host = factory(User::class)->create();

    return [
        'task' => $faker->sentence(),
        'project_id' => $project->id,
        'employee_id' => $employee->id,
        'host_id' => $host->id,
        'completed' => $faker->boolean(),
        'due_at' => $faker->dateTimeBetween('+1 day', '+ 1 month'),
    ];
});