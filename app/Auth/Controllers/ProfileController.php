<?php

namespace App\Auth\Controllers;

use App\Auth\Http\Requests\UpdateProfileRequest;
use App\Auth\Jobs\UpdateUser;
use App\Core\Controllers\Controller;
use Auth;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    /**
     * @return Response
     */
    public function edit()
    {
        return view('auth.profile.edit')->with(['user' => Auth::user()]);
    }

    public function update(UpdateProfileRequest $request)
    {
        $this->dispatch(new UpdateUser($request->user(), $request->all()));

        return redirect()->back();
    }

    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}
