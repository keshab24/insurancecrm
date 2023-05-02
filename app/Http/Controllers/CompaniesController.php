<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (control('create-user')) {
            $companies = Company::all();
            return view('company.index')->with('companies', $companies);
        } else {
            return view('layouts.backend.denied');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],

        ]);
        $company = Company::create($request->all());

        if ($company) {
            return response()->json([
                'status' => 'ok',
                'user' => $company,
                'message' => 'Company is added successfully.'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Company can not be added.'
            ], 422);
        }
    }
    public function product($id)
    {
        $company = Company::findorFail($id);
        return view('company.productView')->with('company', $company);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::findorFail($id);
        return view('company.edit')->with('company', $company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_method', '_token');

        $company = Company::whereId($id)->update($data);

        if ($company) {
            return redirect()->route('companies.index')->withSuccessMessage('Company is Updated successfully.');
        }
        return redirect()->back()->withInput()->withWarningMessage('Company can not be created.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);
        $company->delete();
        if ($company) {
            return response()->json([
                'type' => 'success',
                'message' => 'Company is deleted successfully.'
            ], 200);
        }

        return response()->json([
            'type' => 'error',
            'message' => 'Company can not deleted.'
        ], 422);
    }
    public function updateCompanyStatus(Request $request)
    {
        $company = Company::findOrFail($request->id);
        $company->is_active = !$company->is_active;
        $company->save();

        return redirect()->back();
    }
}
