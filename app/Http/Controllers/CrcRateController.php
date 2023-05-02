<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CrcRate;
use App\Models\Product;
use App\Models\Policy_age;
use Illuminate\Http\Request;

class CrcRateController extends Controller
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

        $crcrate = CrcRate::orderBy('created_at','desc')->get();


        return view('crcrate.create')->with('crcrates',$crcrate)
        ->with('companies',$companies);;
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
       $age = $data['age_id'];
        $company_id = $data['company_id'];
        $product_id = $data['product_id'];
        $data['age_id'] = Policy_age::where('age', $age)->first()->id;
      //  $data['company_id'] = implode(',', $company_id);

        $company = CrcRate::create($data);

        if ($company) {
            return redirect()->route('crcrate.create')->withSuccessMessage('Crc rate is added successfully.');
        }
        return redirect()->back()->withInput()->withWarningMessage('Crc rate can not be created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CrcRate  $crcRate
     * @return \Illuminate\Http\Response
     */
    public function show(CrcRate $crcRate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CrcRate  $crcRate
     * @return \Illuminate\Http\Response
     */
    public function edit(CrcRate $crcRate,$id)
    {
        $crcrate = CrcRate::findorFail($id);

        $companies = Company::all();

        $crcrates = CrcRate::orderBy('created_at','desc')->get();
        $company = Company::where('id',$crcrate->company_id)->first();
        $product = Product::where('id', $crcrate->product_id)->first();

        return view('crcrate.edit')->with('crcrate',$crcrate)
        ->with('companies',$companies)
        ->with('company',$company)
  ->with('product',$product)
        ->with('crcrates',$crcrates);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CrcRate  $crcRate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CrcRate $crcRate,$id)
    {
        $crcrate = CrcRate::findorFail($id);
        $data = $request->except('_token','_method');

        $company_id = $data['company_id'];
        $product_id = $data['product_id'];
      //  $data['company_id'] = implode(',', $company_id);

        $company = CrcRate::where('id',$id)->update($data);
        if ($company) {
            return redirect()->route('crcrate.create')->withSuccessMessage('Crc rate is updated successfully.');
        }
        return redirect()->back()->withInput()->withWarningMessage('Crc rate can not be updated.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CrcRate  $crcRate
     * @return \Illuminate\Http\Response
     */

    public function delete($id)
    {
         $crcrate = CrcRate::findorFail($id);
        if (CrcRate::findorFail($id)) {
            $crcrate->delete();
        }
        return redirect()->route('crcrate.create')->withSuccessMessage('Crc Rate is deleted successfully.');
    }
}
