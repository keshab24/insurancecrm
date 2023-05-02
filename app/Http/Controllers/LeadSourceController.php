<?php

namespace App\Http\Controllers;

use App\Models\LeadSource;
use Illuminate\Http\Request;

class LeadSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['leadsources'] = LeadSource::all();
        return view('Backend.LeadCategories.LeadSource.index', $data);
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
        $leadsource = LeadSource::create($data);
        if ($leadsource) {
            return redirect()->route('admin.leadcategories.leadsource.index')->withSuccessMessage('LeadSource is added successfully.');
        }
        return redirect()->back()->withInput()->withWarningMessage('LeadSource can not be created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeadSource  $leadSource
     * @return \Illuminate\Http\Response
     */
    public function show(LeadSource $leadSource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeadSource  $leadSource
     * @return \Illuminate\Http\Response
     */
    public function edit(LeadSource $leadSource)
    {
        $leadsource = LeadSource::findorfail($id);
        return view('Backend.LeadCategories.LeadSource.edit', compact('leadsource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeadSource  $leadSource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeadSource $leadSource)
    {
        $data = $request->except('_token','_method','leadsource_id');

        $leadsource = LeadSource::where('id', $request->leadsource_id)->update($data);
        if ($leadsource) {
            return redirect()->route('admin.leadcategories.leadsource.index')->withSuccessMessage('LeadSource is updated successfully.');
        }
        return redirect()->back()->withInput()->withWarningMessage('LeadSource Can not be updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeadSource  $leadSource
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flag = LeadSource::destroy($id);
        if ($flag) {
            return response()->json([
                'type' => 'success',
                'message' => 'LeadSource is deleted successfully.'
            ], 200);
        }
        return response()->json([
            'type' => 'error',
            'message' => 'LeadSource can not be deleted.'
        ], 422);
    }
}
