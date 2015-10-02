<?php

namespace App\Core\Controllers;

use App\Auth\Jobs\CreateNewUser;
use App\Contracts\Auth\UserRepository;
use Faker\Factory;

class IndexController extends Controller
{
    /**
     * @param UserRepository $users
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserRepository $users)
    {
        //$user = $users->findByUUID('d45fb359-66e0-11e5-befb-0800279114ca');
        $user = $users->all();

        return view('welcome', ['users' => $user]);
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
                'password' => bcrypt(str_random(10)),
            ]
        ));

        return redirect()->route('home');
    }
}
