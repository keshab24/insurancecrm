<?php

namespace App\Http\Controllers;

use App\Models\PolicySubCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PolicySubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $policy_categories = DB::table('policy_categories')->get();
        $datas = PolicySubCategory::all();
        return view('Backend.PolicySub.index', compact('policy_categories','datas'));
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
        // dd($data);
        $policy_sub_cat = PolicySubCategory::create($data);
        if ($policy_sub_cat) {
            return redirect()->route('admin.policycategories.sub.index')->withSuccessMessage('Policy Sub Category is added successfully.');
        }
        return redirect()->back()->withInput()->withWarningMessage('Policy Sub Category can not be created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PolicySubCategory  $policySubCategory
     * @return \Illuminate\Http\Response
     */
    public function show(PolicySubCategory $policySubCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PolicySubCategory  $policySubCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $policy_categories = DB::table('policy_categories')->get();
        $policy_sub_category = PolicySubCategory::findorfail($id);
        return view('Backend.PolicySub.edit', compact('policy_categories','policy_sub_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PolicySubCategory  $policySubCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token','_method','sub_id');

        $policy_sub_category = PolicySubCategory::where('id', $request->sub_id)->update($data);
        if ($policy_sub_category) {
            return redirect()->route('admin.policycategories.sub.index')->withSuccessMessage('Policy Sub Category is updated successfully.');
        }
        return redirect()->back()->withInput()->withWarningMessage('Policy Sub Category Can not be updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PolicySubCategory  $policySubCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flag = PolicySubCategory::destroy($id);
        if ($flag) {
            return response()->json([
                'type' => 'success',
                'message' => 'Policy Sub Category is deleted successfully.'
            ], 200);
        }
        return response()->json([
            'type' => 'error',
            'message' => 'Policy Sub Category can not be deleted.'
        ], 422);
    }
}
