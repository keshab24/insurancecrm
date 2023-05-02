<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\Term;
use App\Models\Company;
use App\Models\Product;
use App\Models\WholeAdb;
use App\Models\MoneyBack;
use App\Models\Policy_age;
use App\Models\SumAssured;
use App\Models\Term_rider;
use App\Models\BonusRateEP;
use Illuminate\Http\Request;
use App\Models\LoadingCharge;
use App\Models\Rate_endowment;


class WholelifeController extends Controller
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
        $lod = LoadingCharge::all();
        $companies = Company::all();
        return view('Wholelife.create', compact('lod', 'companies'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customMessages = [
            'mod10000' => 'The sum assured should be multiple of 10000.'
        ];

        $validatedData = $request->validate([

            'age' => ['required', 'numeric'],
            'term' => ['required'],
            'sum_assured' => ['required','mod10000'],
        ],$customMessages);


        $data = $request->input();
        $products = Product::where('company_id', $request->company_id)->get();
        $product = Product::where('id', $request->product_id)->first();
        $company = Company::where('id', $request->company_id)->first();

        $sum_assured = $request->sum_assured;

        // $moneyBackCalc->Charge = LoadingCharge::value($request->loading_charge);
        // dd($moneyBackCalc);
        $discountonSA = SumAssured::where('first_amount', '<=', $request->sum_assured)->where('second_amount', '>=', $request->sum_assured)->where('company_id',$company->id)->where('product_id',$product->id)->first();


        $bonusrate = BonusRateEP::where('first_year', '<=', $request->term)->where('second_year', '>=', $request->term)->where('company_id',$company->id)->where('product_id',$product->id)->first();

       
        $policyagerate = Policy_age::where('age', '=', $request->age)->first();
        $term = Term::where('term', '=', $request->term)->first();

        $charge = LoadingCharge::where('company_id', $request->company_id)
        ->where('product_id', $request->product_id)->value($request->loading_charge);

        $tableRate = Rate_endowment::where('age_id', '=', $policyagerate->id)->where('term_id', '=', $term->id)->where('company_id', $request->company_id)
        ->where('product_id', $request->product_id)->first();

        $newRate = 0;
        if (isset($charge)) {
            $newRate = $tableRate->rate * $charge - $discountonSA;;
        } else {
            $newRate = $tableRate->rate - $discountonSA;
        }

       
       
        $premiumAmount = ($newRate / 1000) * ($request->sum_assured);
       

       if($request->company_id == 4){
        $aDB = WholeAdb::where('age_id', '=', $policyagerate->id)->where('term_id', '=', $term->id)->where('company_id', $request->company_id)
            ->where('product_id', $request->product_id)->first()->rate;

        $termRiderTR = Term_rider::where('age_id', '=', $policyagerate->id)->where('term_id', '=', $term->id)->where('company_id', $request->company_id)
            ->first()->rate;

            $Adptb = [];
            $discountonmop = [];

            $accBenefit = ($aDB * ($request->sum_assured)) / 1000;
            $trAmount = $termRiderTR * (400000 / 1000);
            $totalPremium = $premiumAmount + $accBenefit + $trAmount;
    }

        if($request->company_id == 7){
            $accBenefit = [];
            $trAmount = [];
            $totalPremium = [];
            $aDB = 1;
            $termRiderTR = 1;
            $Adptb = ($aDB+$termRiderTR)/1000 * $sum_assured;
            $discountonmop = $charge * $premiumAmount;
            }
        // dd($totalPremium);

        $companies = Company::all();

        return view('Wholelife.result')->with('discountonSA', $discountonSA)
            ->with('aDB', $aDB)
            ->with('sum_assured', $request->sum_assured)
            ->with('term', $request->term)
            ->with('age', $request->age)
            ->with('tableRate', $tableRate)
            ->with('companies', $companies)
            ->with('company',$company)
            ->with('loading_charge',request('loading_charge'))
            ->with('adptb', $Adptb)

            ->with('product',$product)
            ->with('termRiderTR', $termRiderTR)
            ->with('newRate', $newRate)
            ->with('charge', $charge)
            ->with('premiumAmount', $premiumAmount)
            ->with('accBenefit', $accBenefit)
            ->with('trAmount', $trAmount)
            ->with('bonusrate', $bonusrate)
            ->with('discountonmop', $discountonmop)

            ->with('sum_assured', request('sum_assured'))
            ->with('totalPremium', $totalPremium);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
