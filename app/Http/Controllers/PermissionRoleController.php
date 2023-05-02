<?php

namespace App\Http\Controllers;

use App\Models\PermissionRole;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;

class PermissionRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $page['title'] = 'Permission_role';
        return view("Backend.PermissionRole.index", compact('page'));
    }

    /**
     * Get datatable format json file.
     */
    public function getpermission_rolesJson(Request $request)
    {
        return $permissionRoles = PermissionRole::all();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $page['title'] = 'Permission_role | Create';
        $roles = Role::where(['deleted_at' => null, 'deleted_by' => null])->get();
        $permissions = Permission::where(['deleted_at' => null, 'deleted_by' => null])->get();
        return view("Backend.PermissionRole.add", compact('page', 'roles', 'permissions'));
    }

    public function permisson_roles()
    {
        $permission_role = DB::table('permission_role')->get();
        return response()->json($permission_role);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
//        $success = PermissionRole::Create($data);
        DB::table('permission_role')->delete();
        if (isset($data['role_permission'])) {
            foreach ($data['role_permission'] as $key => $value) {
                $temp = explode("_", $key);
                DB::table('permission_role')->insert([
                    'permission_id' => $temp[1],
                    'role_id' => $temp[0]
                ]);
            }
        }


        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $permission_role = PermissionRole::findOrFail($id);
        $page['title'] = 'Permission_role | Update';
        return view("Backend.PermissionRole.edit", compact('page', 'permission_role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $success = PermissionRole::where('id', $id)->update($data);
        return redirect()->route('admin.privilege.permission_roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $data['del_flag'] = 0;
        $success = PermissionRole::where('id', $id)->update($data);
        return redirect()->route('admin.privilege.permission_roles');
    }
}
