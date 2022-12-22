<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        //  emailの代わりに使用したいカラム名を指定する
        return 'user_id';
    }

    protected function attemptLogin(Request $request)
    {
        $username = $request->input($this->username());
        $password = $request->input('password');

        if (filter_var($username, \FILTER_VALIDATE_EMAIL)) {
            $credentials = ['email' => $username, 'password' => $password];
        } else {
            $credentials = [$this->username() => $username, 'password' => $password];
        }

        return $this->guard()->attempt($credentials, $request->filled('remember'));
    }

    protected function loggedOut(Request $request) {
        return redirect('login');
    }
}
