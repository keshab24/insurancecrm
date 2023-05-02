<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if (control('create-user')) {
            $data['roles'] = Role::all();
            $data['users'] = User::all();
            return view('Backend.User.index', $data);
        } else {
            return view('layouts.backend.denied');
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        // return view('configuration::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
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

        $data['username'] = $request->username;
        $data['designation'] = $request->designation;
        $data['email'] = $request->email;
        $data['phone_number'] = $request->phone_number;
        $data['is_active'] = $request->is_active;
        $data['role_id'] = $request->role_id;
        $data['password'] = Hash::make($request->password);
        //        return $data;
        $user = User::Create($data);
        if ($user) {
            return response()->json([
                'status' => 'ok',
                'user' => $user,
                'message' => 'User is added successfully.'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User can not be added.'
            ], 422);
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return response()->json([
            'status' => 'ok',
            'user' => $user
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('Backend.User.edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @return Response
     */
    public function modify(Request $request, $id)
    {
//        return $id;
        try {
            $this->validate(
                $request,
                [
                    'username' => 'required',
                    'email' => 'required',
                    'phone_number' => 'exclude_if:phone_number,null|digits_between:10,13'
                ],
                [
                    'username.required' => 'Name Cannot Be Empty!!',
                    'email.required' => 'Email Cannot Be Empty!!',
                ]
            );
            $data['username'] = $request->username;
            $data['email'] = $request->email;
            if ($request->password) {
                $data['password'] = Hash::make($request->password);
            }
            $user = User::where('id', $id)->update($data);
            if ($user) {
                return redirect()->back()->withSuccessMessage('User updated Successfully');
            }
            return redirect()->back()->withErrors('Something went wrong');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Something went wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'username' => 'required',
                'email' => 'required',
                'role_id' => 'required',
                'phone_number' => 'exclude_if:phone_number,null|digits_between:10,13'
            ],
            [
                'username.required' => 'Name Cannot Be Empty!!',
                'email.required' => 'Email Cannot Be Empty!!',
                'role_id.required' => 'Role Cannot Be Empty!!',
            ]
        );
        try {
            $data['phone_number'] = $request->phone_number;
            $data['username'] = $request->username;
            $data['designation'] = $request->designation;
            $data['email'] = $request->email;
            $data['is_active'] = $request->is_active;
            $data['role_id'] = $request->role_id;
            if ($request->password) {
                $data['password'] = Hash::make($request->password);
            }
            $user = User::where('id', $id)->update($data);
            if ($user) {
                return response()->json([
                    'status' => 'ok',
                    'user' => $user,
                    'message' => 'User is updated successfully.'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User can not be updated.'
                ], 422);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json([
                'status' => 'ok',
                'message' => 'User is deleted successfully.'
            ], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'User can not be deleted.'
            ], 422);
        }
    }

    /**
     * Change status of the specified user from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->is_active == '0' ? $user->is_active = '1' : $user->is_active = '0';
            $user->save();
            $message = ($user->is_active == '1') ? "User is activated successfully." : "User is deactivated successfully.";
            return response()->json([
                'status' => 'ok',
                'user' => $user,
                'message' => $message
            ], 200);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function users(Request $request)
    {
        return response()->json([
            'status' => 'ok',
            'users' => User::all(),
        ], 200);
    }

    public function manuallogin($id)
    {
        if (control('create-user')) {

            $user = User::find($id);

            Auth::login($user);
            return redirect('/dashboard');
        } else {
            return view('layouts.backend.denied');
        }
    }

    public function downloadExcel(Request $request)
    {
        return Excel::download(new UsersExport, 'user-list.xlsx');
    }
}
