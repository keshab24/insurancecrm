<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Carbon\Carbon;
use DataTables;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['permissions'] = Permission::where(['deleted_at' => null, 'deleted_by' => null])->get();
        return view("Backend.Permission.index", $data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $page['title'] = 'Permission | Create';
        return view("Backend.Permission.add", compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token', 'name');
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
        $data['name'] = Str::slug($request->name);
        $success = Permission::Create($data);
        return redirect()->route('admin.privilege.permission.index');
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
    public function edit(Request $request,$id)
    {
        $data['permission'] = Permission::findOrFail($id);
        $data['title'] = 'Permission | Update';
        return view("Backend.Permission.edit", $data);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $id = $request->id;
        $data = $request->except('_token', '_method', 'name', 'id');
        $data['name'] = Str::slug($request->name);
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
        $success = Permission::where('id', $id)->update($data);
        return redirect()->route('admin.privilege.permission.index');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|RedirectResponse
     */
    public function destroy(Request $request,$id)
    {
        $data['deleted_at'] = Carbon::now();
        $data['deleted_by'] = Auth::user()->id;
        $success = Permission::where('id', $id)->update($data);

        if ($request->ajax()) {
            if ($success) {
                $success_status = true;
                $message = config('messages.message.delete_success');
            } else {
                $success_status = false;
                $message = config('messages.message.delete_failed');
            }
            return response()->json(['success' => $success_status, 'message' => $message], ($success_status) ? 200 : 400);
        } else {
            if ($success)
                Session::flash('success', config('messages.message.delete_success'));
            else
                Session::flash('fail', config('messages.message.delete_failed'));
            return redirect()->route('admin.privilege.permission.index', getPrefix());
        }
    }
}
