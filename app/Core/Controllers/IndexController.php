<?php

namespace App\Core\Controllers;

use App\Auth\Jobs\CreateNewUser;
use App\Auth\Models\User;
use App\Contracts\Auth\UserRepository;
use Faker\Factory;

class IndexController extends Controller
{
    /**
     * Load up the angular app.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function angular()
    {
        return view('index');
    }
}
