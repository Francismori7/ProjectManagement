<?php

namespace App\Auth\Controllers\Api\v1;

use App\Auth\Http\Requests\UpdateProfileRequest;
use App\Auth\Jobs\UpdateUser;
use App\Core\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware('jwt.refresh');
    }

    /**
     * Updates the user's profile with the new data.
     *
     * POST /api/v1/profile/update
     *
     * @param UpdateProfileRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = $this->dispatch(new UpdateUser($request->user(), $request->all()));

        return response()->json(compact('user'));
    }
}
