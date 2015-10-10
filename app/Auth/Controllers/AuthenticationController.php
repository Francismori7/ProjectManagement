<?php

namespace App\Auth\Controllers;

use App\Auth\Jobs\CreateNewUser;
use App\Auth\Models\User;
use App\Core\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthenticationController extends Controller
{
    /**
     * AuthenticationController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest', ['only' => ['login', 'register']]);
        $this->middleware('jwt.refresh', ['only' => ['logout', 'me']]);
        $this->middleware('jwt.auth', ['only' => ['logout', 'me']]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, ['username' => 'required', 'password' => 'required']);

        try {
            if (!$token = JWTAuth::attempt($request->only('username', 'password'))) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    /**
     * Registers a new user and returns its JSON web token.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validate($request, self::getValidatorRules());

        $token = JWTAuth::fromUser(
            $this->create($request->all())
        );

        return response()->json(compact('token'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return array
     */
    public static function getValidatorRules()
    {
        /** @var User $user */
        $user = new User;
        if (JWTAuth::getToken()) {
            $user = JWTAuth::parseToken()->authenticate();
        }

        return [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'username' => 'sometimes|required|alpha_dash|max:30|unique:' . User::class . ',username,' . $user->getId(),
            'email' => 'sometimes|required|email|max:255|unique:' . User::class . ',email,' . $user->getId(),
            'password' => 'sometimes|required|min:8|confirmed',
        ];
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        return $this->dispatch(new CreateNewUser($data));
    }

    /**
     * Returns the user's details.
     *
     * @param Guard $auth
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Guard $auth)
    {
        return response()->json($auth->user());
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['logged_out']);
    }
}
