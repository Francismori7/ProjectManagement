<?php

namespace App\Auth\Controllers;


use App\Auth\Http\Requests\UpdateProfileRequest;
use App\Contracts\Auth\UserRepository;
use App\Core\Controllers\Controller;
use Auth;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return Response
     */
    public function edit()
    {
        return view('auth.profile.edit')->with(['user' => Auth::user()]);
    }

    public function update(UpdateProfileRequest $request, UserRepository $users)
    {
        $user = Auth::user();
        $user->setFirstName($request->input('first_name'))
            ->setLastName($request->input('last_name'))
            ->setUsername($request->get('username'))
            ->setEmail($request->get('email'));

        $users->save($user)->flush();
        return redirect()->back();
    }
}