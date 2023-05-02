<?php

namespace App\Http\Controllers;

use App\Models\SumAssured;
use App\Models\Company;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use discount_on_sa;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class SumAssuredController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $discount = SumAssured::orderBy('created_at', 'desc')->get();
        $product = Product::all();
        $company = Company::all();
        return view('SumAssured.view', compact('discount', 'product', 'company'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        $companies = Company::orderBy('created_at', 'asc')->get();
        $products = Product::orderBy('created_at', 'asc')->get();
        return view('SumAssured.create', compact('companies', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        $validation = [
            'company_id' => 'required',
            'product_id' => 'required',
            'first_amount' => 'required|numeric|gte:0',
            'discount_value' => 'required'
        ];

        if (!$request->has('above_case')) {
            $validation['second_amount'] = 'required|numeric|gt:first_amount';
        }

        $request->validate($validation);

        $data = $request->input();

        if ($request->has('above_case')) {
            $data['second_amount'] = 2147483647;
        }

        try {
            $discount = new SumAssured;
            $discount->first_amount = $data['first_amount'];
            $discount->second_amount = $data['second_amount'];
            $discount->discount_value = $data['discount_value'];
            $discount->company_id = $data['company_id'];
            $discount->product_id = $data['product_id'];
            $discount->save();

            return redirect('discountList')->with('success_message', 'Discount range created successfully!');
        } catch (Exception $e) {
            return back()->with('error_message', 'Failed to create Discount range!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param SumAssured $sumAssured
     * @return Response
     */
    public function show(SumAssured $sumAssured)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Application|Factory|View|Response
     */
    public function edit($id)
    {
        $companies = Company::orderBy('created_at', 'asc')->get();
        $products = Product::all();
        $discount = SumAssured::find($id);
        return view('SumAssured.edit', compact('companies', 'products', 'discount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, $id)
    {
        $validation = [
            'company_id' => 'required',
            'product_id' => 'required',
            'first_amount' => 'required|numeric|gte:0',
            'discount_value' => 'required'
        ];

        if (!$request->has('above_case')) {
            $validation['second_amount'] = 'required|numeric|gt:first_amount';
        }

        $request->validate($validation);

        $data = SumAssured::find($request->id);
        $data->company_id = $data['company_id'];
        $data->product_id = $data['product_id'];
        $data->first_amount = $request['first_amount'];
        $data->second_amount = $request->has('above_case') ? $data->second_amount : $request['second_amount'];
        $data->discount_value = $request['discount_value'];
        $data->save();
        return redirect('discountList')->with('success_message', 'Discount range created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function destroy($id)
    {
        $discount = SumAssured::find($id);
        if (SumAssured::find($discount)) {
            $discount->delete();
        }
        return redirect('discountList');
    }
}
