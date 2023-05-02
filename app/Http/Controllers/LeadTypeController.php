<?php

namespace App\Http\Controllers;

use App\Models\LeadType;
use Illuminate\Http\Request;

class LeadTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['leadtypes'] = LeadType::all();
        return view('Backend.LeadCategories.LeadType.index', $data);
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
        $leadtype = LeadType::create($data);
        if ($leadtype) {
            return redirect()->route('admin.leadcategories.leadtypes.index')->withSuccessMessage('LeadType is added successfully.');
        }
        return redirect()->back()->withInput()->withWarningMessage('LeadType can not be created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeadType  $leadType
     * @return \Illuminate\Http\Response
     */
    public function show(LeadType $leadType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeadType  $leadType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['leadtype'] = LeadType::findorfail($id);
        return view('Backend.LeadCategories.LeadType.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeadType  $leadType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token','_method','leadtype_id');

        $leadtype = LeadType::where('id', $request->leadtype_id )->update($data);

        if ($leadtype) {
            return redirect()->route('admin.leadcategories.leadtypes.index')->withSuccessMessage('LeadType is updated successfully.');
        }
        return redirect()->back()->withInput()->withWarningMessage('LeadType Can not be updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeadType  $leadType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flag = LeadType::destroy($id);
        if ($flag) {
            return response()->json([
                'type' => 'success',
                'message' => 'LeadType is deleted successfully.'
            ], 200);
        }
        return response()->json([
            'type' => 'error',
            'message' => 'LeadType can not be deleted.'
        ], 422);
    }
}
