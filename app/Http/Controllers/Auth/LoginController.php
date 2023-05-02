<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/admin/leadcategories/leadsource';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $phone_number = $request->phone_number;
        $password = $request->password;
        $remember_me = $request->has('remember') ? true : false;

        if (Auth::attempt(['phone_number' => $phone_number, 'password' => $password, 'is_active' => '0'])) {
            $this->guard()->logout();
            return redirect()->back()->withInput()
                ->withErrorMessage('You are not activated. Please contact Administration');
        }

        if (Auth::attempt(['phone_number' => $phone_number, 'password' => $password, 'is_active' => '1'], $remember_me)) {
            return redirect()->route('dashboard');
        }
        return redirect()->back()->withInput()
            ->withErrorMessage('Invalid Phone Number or Password.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/admin');
    }
}
