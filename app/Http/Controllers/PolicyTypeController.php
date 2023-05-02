<?php

namespace App\Http\Controllers;

use App\Models\PolicyType;
use App\Models\PolicySubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PolicyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $policy_categories = DB::table('policy_categories')->get();
        $policy_sub_categories = PolicySubCategory::where('is_active','1')->get();
        $types = PolicyType::all();
// dd($policy_sub_categories);
        return view('Backend.Type.index', compact('policy_categories','policy_sub_categories','types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $type = PolicyType::create($data);

        if ($type) {
            return redirect()->route('admin.policycategories.type.index')->withSuccessMessage('Policy Type is added successfully.');
        }
        return redirect()->back()->withInput()->withWarningMessage('Policy Type can not be created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PolicyType  $policyType
     * @return \Illuminate\Http\Response
     */
    public function show(PolicyType $policyType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PolicyType  $policyType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $policy_categories = DB::table('policy_categories')->get();
        $policy_sub_categories = PolicySubCategory::where('is_active','1')->get();
        $type = PolicyType::findorfail($id);

        return view('Backend.Type.edit', compact('policy_categories','policy_sub_categories','type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PolicyType  $policyType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token','_method','type_id');

        $type = PolicyType::where('id', $request->type_id)->update($data);
        if ($type) {
            return redirect()->route('admin.policycategories.type.index')->withSuccessMessage('Policy Type is updated successfully.');
        }
        return redirect()->back()->withInput()->withWarningMessage('Policy Type Can not be updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PolicyType  $policyType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flag = PolicyType::destroy($id);

        if ($flag) {
            return response()->json([
                'type' => 'success',
                'message' => 'Policy Type is deleted successfully.'
            ], 200);
        }
        return response()->json([
            'type' => 'error',
            'message' => 'Policy Type can not be deleted.'
        ], 422);
    }
}
