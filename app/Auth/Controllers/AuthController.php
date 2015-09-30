<?php

namespace App\Auth\Controllers;

use Validator;

use App\Auth\Models\User;
use App\Auth\Jobs\CreateNewUser;
use App\Core\Controllers\Controller;
use App\Auth\Http\Requests\RegisterUserRequest;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    private static $validatorRules = [
        'first_name' => 'required|max:50',
        'last_name' => 'required|max:50',
        'username' => 'required|max:30|unique:' . User::class,
        'email' => 'required|email|max:255|unique:' . User::class,
        'password' => 'required|min:8|confirmed',
    ];
    protected $redirectAfterLogout = '/';
    protected $loginPath = '/auth/login';
    protected $username = 'username';
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return array
     */
    public static function getValidatorRules()
    {
        return self::$validatorRules;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  RegisterUserRequest $request
     * @param Guard $auth
     * @return \Illuminate\Http\Response
     */
    public function postRegister(RegisterUserRequest $request, Guard $auth)
    {
        $auth->login($this->create($request->all()));

        return redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return $this->dispatch(new CreateNewUser($data));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, self::$validatorRules);
    }
}
