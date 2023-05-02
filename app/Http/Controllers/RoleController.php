<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\Role;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roles;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $data['roles'] = Role::all();
        return view('Backend.Role.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Backend.Role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->except('_token');
            $this->validate($request, [
                'name' => 'required|unique:roles,name',
                'display_name' => 'required',
                'description' => 'required',
            ],
                [
                    'name.required' => 'Name Cannot Be Empty!!',
                    'display_name.required' => 'Password Cannot Be Empty!!',
                    'description.required' => 'Description Cannot Be Empty!!',
                ]);
            $data['created_at'] = Carbon::now();
            $data['updated_at'] = Carbon::now();
            $success = Role::Create($data);
            session()->flash('success_message', 'Role is added successfully.');
            return redirect()->route('admin.privilege.role.index');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        return response()->json([
            'status' => 'ok',
            'role' => $role
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data['role'] = Role::findOrFail($id);
            return view('Backend.Role.edit',$data);
        } catch (Exception $e) {
            return $e->getMessage();
//            return view('layouts.backend.denied');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $id = $request->id;
            $data = $request->except('_method','_token', 'id');
            $this->validate($request, [
                'name' => 'required',
                'display_name' => 'required',
                'description' => 'required',
            ],
                [
                    'name.required' => 'Name Cannot Be Empty!!',
                    'display_name.required' => 'Password Cannot Be Empty!!',
                    'description.required' => 'Description Cannot Be Empty!!',
                ]);
            $success = Role::where('id', $id)->update($data);
            session()->flash('success_message', 'Role is updated successfully.');
            return redirect()->route('admin.privilege.role.index');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete($id);
        if ($role) {
            return response()->json([
                'type' => 'success',
                'message' => 'Role is deleted successfully.'
            ], 200);
        }

        return response()->json([
            'type' => 'error',
            'message' => 'Role can not deleted.'
        ], 422);
    }
}
