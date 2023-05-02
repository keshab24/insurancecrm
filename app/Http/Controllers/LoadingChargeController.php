<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\LoadingCharge;

class LoadingChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();

        $loadingCharge = LoadingCharge::orderBy('created_at', 'desc')->get();


        $loadingCharge = LoadingCharge::orderBy('created_at', 'desc')->get();
        return view('loadingcharge.create')->with('loadingcharges', $loadingCharge)
            ->with('companies', $companies);
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
        $company_id = $data['company_id'];
        $product_id = $data['product_id'];
        //  $data['company_id'] = implode(',', $company_id);

        $company = LoadingCharge::create($data);

        if ($company) {
            return redirect()->route('loadingcharges.create')->withSuccessMessage('Loading Charges is added successfully.');
        }
        return redirect()->back()->withInput()->withWarningMessage('Loading charges can not be created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoadingCharge  $loadingCharge
     * @return \Illuminate\Http\Response
     */
    public function show(LoadingCharge $loadingCharge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoadingCharge  $loadingCharge
     * @return \Illuminate\Http\Response
     */
    public function edit(LoadingCharge $loadingCharge, $id)
    {
        $loadingcharge = LoadingCharge::findorFail($id);

        $companies = Company::all();

        $loadingcharges = loadingcharge::orderBy('created_at', 'desc')->get();
        $company = Company::where('id', $loadingcharge->company_id)->first();
        $product = Product::where('id', $loadingcharge->product_id)->first();

        return view('loadingcharge.edit')->with('loadingcharge', $loadingcharge)
            ->with('companies', $companies)
            ->with('company', $company)
            ->with('product', $product)
            ->with('loadingcharges', $loadingcharges);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LoadingCharge  $loadingCharge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoadingCharge $loadingCharge, $id)
    {
        $crcrate = LoadingCharge::findorFail($id);
        $data = $request->except('_token', '_method');

        $company_id = $data['company_id'];
        $product_id = $data['product_id'];
        //  $data['company_id'] = implode(',', $company_id);

        $company = LoadingCharge::where('id', $id)->update($data);
        if ($company) {
            return redirect()->route('loadingcharges.create')->withSuccessMessage('Loading charge is updated successfully.');
        }
        return redirect()->back()->withInput()->withWarningMessage('loading charge can not be updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoadingCharge  $loadingCharge
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoadingCharge $loadingCharge)
    {
        //
    }
    public function delete($id)
    {
        $crcrate = LoadingCharge::findorFail($id);
        if (LoadingCharge::findorFail($id)) {
            $crcrate->delete();
        }
        return redirect()->route('loadingcharges.create')->withSuccessMessage('Loading Charge is deleted successfully.');
    }
}
