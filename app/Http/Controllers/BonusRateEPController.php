<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Company;
use App\Models\Product;
use App\Models\BonusRateEP;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use bonus_rate_for_endowment;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class BonusRateEPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $product = Product::all();
        $bonusRate = BonusRateEP::orderBy('created_at', 'desc')->get();
        return view('BonusRateEP.view', compact('product', 'bonusRate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $companies = Company::all();
        $product = Product::all();
        return view('BonusRateEP.create', compact('companies', 'product'));
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
            'first_year' => 'required|numeric|gte:0',
            'term_rate' => 'required',
            'company_id' => 'required',
            'product_id' => 'required',
        ];

        if (!$request->has('above_case')) {
            $validation['second_year'] = 'required|numeric|gte:first_year';
        }

        $request->validate($validation);

        $data = $request->input();

        if ($request->has('above_case')) {
            $data['second_year'] = 2147483647;
        }

        $bonusRate = new BonusRateEP();
        $bonusRate->first_year = $data['first_year'];
        $bonusRate->second_year = $data['second_year'];
        $bonusRate->company_id = $data['company_id'];
        $bonusRate->product_id = $data['product_id'];
        $bonusRate->company_id = $data['company_id'];
        $bonusRate->term_rate = $data['term_rate'] / 1000;
        $bonusRate->save();

        return redirect('bonusList')->with('success_message', 'Bonus Rate created successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param BonusRateEP $bonusRateEP
     * @return Response
     */
    public function show(BonusRateEP $bonusRateEP)
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
        $bonusRate = BonusRateEP::find($id);
        $products = Product::all();
        $companies = Company::all();

        return view('BonusRateEP.edit', compact('bonusRate', 'products', 'companies'));
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
            'first_year' => 'required|numeric|gte:0',
            'term_rate' => 'required',
            'company_id' => 'required',
            'product_id' => 'required',
        ];

        if (!$request->has('above_case')) {
            $validation['second_year'] = 'required|numeric|gte:first_year';
        }

        $request->validate($validation);

        $data = BonusRateEP::find($request->id);
        $data->first_year = $request['first_year'];
        $data->second_year = $request['second_year'];
        $data->product_id = $request['product_id'];
        $data->company_id = $request['company_id'];
        $data->term_rate = $request['term_rate'];

        $data->save();

        return redirect('bonusList')->with('success', 'bonus rate created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function destroy($id)
    {
        $bonusRate = BonusRateEP::find($id);
        if (BonusRateEP::find($bonusRate)) {
            $bonusRate->delete();
        }
        return redirect('bonusList');
    }
}
