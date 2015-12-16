<?php

namespace App\Auth\Controllers\Api\v1;

use App\Auth\Http\Requests\EmailPasswordResetLinkRequest;
use App\Auth\Http\Requests\LoginUserRequest;
use App\Auth\Http\Requests\ResetPasswordRequest;
use App\Auth\Jobs\CreateNewUser;
use App\Auth\Models\User;
use App\Contracts\Auth\UserRepository;
use App\Core\Controllers\Controller;
use App\Projects\Models\Invitation;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use JWTAuth;
use Password;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticationController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * Authenticates the user and returns its JSON web token.
     *
     * POST /api/v1/auth/login
     *
     * @param LoginUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginUserRequest $request)
    {
        try {
            if (! $token = JWTAuth::attempt($request->only('username', 'password'))) {
                return response()->json(['error' => 'invalid_credentials'], 402);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    /**
     * Registers a new user and returns its JSON web token.
     *
     * POST /api/v1/auth/register/{invitation}
     *
     * @param Invitation $invitation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Invitation $invitation, Request $request)
    {
        $this->validate($request, self::getValidatorRules());

        /**
         * We make sure this is the right email for the invitation, we do not
         * want to allow another user to register with an invitation code.
         */
        $email = $request->input('email');
        if ($email !== $invitation->email) {
            return response()->json(['error' => 'wrong_email_for_invitation'], 401);
        }

        $user = $this->create($request->all(), $invitation);
        $token = JWTAuth::fromUser(
            $user
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
            'username' => 'required|alpha_dash|max:30|unique:' . $user->getTable() . ',username,' . $user->id,
            'email' => 'required|email|confirmed|max:255|unique:' . $user->getTable() . ',email,' . $user->id,
            'password' => 'sometimes|required|min:8|confirmed',
        ];
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @param Invitation $invitation
     * @return User
     */
    protected function create(array $data, Invitation $invitation)
    {
        return $this->dispatch(new CreateNewUser($data, $invitation));
    }

    /**
     * Returns the user's details.
     *
     * GET /api/v1/auth/me
     *
     * @param Guard $auth
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Guard $auth)
    {
        return response()->json($auth->user());
    }

    /**
     * Logs the user out by invalidating its JSON web token.
     *
     * GET /api/v1/auth/logout
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['logged_out']);
    }

    /**
     * Sends an email to the user to reset its password.
     *
     * POST /api/v1/auth/email
     *
     * @param EmailPasswordResetLinkRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function email(EmailPasswordResetLinkRequest $request)
    {
        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject($this->getEmailSubject());
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return response()->json(['status' => 'reset_link_sent']);

            case Password::INVALID_USER:
                return response()->json(['status' => 'invalid_user'], 401);
        }

        return response()->json(['status' => 'error']);
    }

    /**
     * Get the e-mail subject line to be used for the reset link email.
     *
     * @return string
     */
    protected function getEmailSubject()
    {
        return 'Your password reset link';
    }

    /**
     * Resets the user's password with a valid password reset token.
     *
     * POST /api/v1/auth/reset
     *
     * @param ResetPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(ResetPasswordRequest $request)
    {
        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = Password::reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        if ($response === Password::PASSWORD_RESET) {
            $user = $this->userRepository->findByEmail($request->email);

            $token = JWTAuth::fromUser($user);

            return response()->json(compact('token'));
        }

        return response()->json(['error' => trans($response)]);
    }

    /**
     * Reset the given user's password.
     *
     * @param  User $user
     * @param  string $password
     * @return string User's token
     */
    protected function resetPassword($user, $password)
    {
        $user->password = bcrypt($password);

        $this->userRepository->save($user);
    }

    /**
     * AuthenticationController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('guest', ['only' => ['login', 'register', 'email', 'reset']]);
        $this->middleware('jwt.auth', ['only' => ['logout', 'me']]);

        $this->userRepository = $userRepository;
    }
}
