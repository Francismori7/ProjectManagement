<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Repositories\UserRepository;
use App\User;

Route::get('/', function (UserRepository $users) {
    $faker = Faker\Factory::create();

    $user = (new User)->setEmail($faker->email)
        ->setPassword($faker->word)
        ->setUserName($faker->userName)
        ->setFirstName($faker->firstName)
        ->setLastName($faker->lastName);

    $users->persist($user);
    $users->flush();

    return view('welcome', [
        'users' => $users->findAll()
    ]);
});
