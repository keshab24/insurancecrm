<?php

namespace App\Http\Controllers\Auth;

use App\Models\UserAgent;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }


    public function showRegistrationForm()
    {
        $data['companies'] = Company::all();
        return view('auth.register', $data);
    }

    public function adduser(Request $request)
    {

        $this->validate(
            $request,
            [
                'username' => 'required',
                'password' => 'required|min:6',
                'email' => 'required|email|unique:users,email',
                'phone_number' => 'exclude_if:phone_number,null|digits_between:10,13|unique:users,phone_number'
            ],
            [
                'username.required' => 'Name Cannot Be Empty!!',
                'password.required' => 'Password Cannot Be Empty!!',
                'email.required' => 'Email Cannot Be Empty!!',
            ]
        );
        //        return $request;
        $data['username'] = $request->username;
        $data['phone_number'] = $request->phone_number;
        $data['email'] = $request->email;
        $data['role_id'] = $request->role_id ?? '4';
        $data['password'] = Hash::make($request->password);
        $user = User::Create($data);
        //        $details = array();
        if ($request->company_id && $user) {
            foreach ($request->company_id as $key => $comp) {
                $ref = $request->liscence_number[$key] ?? '';
                $agent = UserAgent::create([
                    'user_id' => $user->id,
                    'company_id' => $comp,
                    'liscence_number' => $ref
                ]);
                //                $detls = array(
                //                    'company_id' => $comp,
                //                    'reference_id' => $ref
                //                );
                //                $details[] = $detls;
            }
            //            $company_details = json_encode($details);
        }

        //        dd ($company_details);
        $data['frm'] = 1;
        if ($data['role_id'] == 5) {
            return redirect()->back()->withSuccess_message('You are registered as an agent.We will verify soon and get back to you !');
        }
        return redirect()->back()->withSuccess_message('You are registered successfully .We will verify soon and get back to you !');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => 5,
            'company_details' => $company_details ?? '',
        ]);
    }
}
