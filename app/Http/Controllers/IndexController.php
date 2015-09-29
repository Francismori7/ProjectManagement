<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Jobs\Users\CreateNewUser;
use App\Repositories\Contracts\UserRepository;
use Faker\Factory;

class IndexController extends Controller
{
    /**
     * @param UserRepository $users
     * @return \Illuminate\Http\Response
     */
    public function index(UserRepository $users)
    {
        return view('welcome', ['users' => $users->findAll()]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        $faker = Factory::create();

        $this->dispatch(new CreateNewUser(
            [
                'username' => $faker->userName,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->email,
                'password' => bcrypt(str_random(10))
            ]
        ));

        return redirect()->route('home');
    }
}
