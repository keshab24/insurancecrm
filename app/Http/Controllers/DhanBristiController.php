<?php

namespace App\Http\Controllers;

use App\Models\DhanBristi;
use App\Models\Company;
use App\Models\PaybackSchedule;
use App\Models\Policy_age;
use App\Models\Product;
use App\Models\Rate_endowment;
use App\Models\Term;
use App\Models\BonusRateEP;
use App\Models\Term_rider;
use Exception;
use Illuminate\Http\Request;

// use App\Models\LoadingCharge;

class DhanBristiController extends Controller
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (in_array('all', AgentCat())) {
            $companies = Company::orderBy('created_at', 'asc')->get();
        } else {
            $companies =  Company::whereIn('id', AgentCategories())->get();
        }
        $products = Product::where('category', 'dhan-bristi')->get();
        $companies = Company::orderBy('created_at', 'asc')->get();

        foreach ($companies as $company) {
            $company->products = $company->dhan_bristi();
            foreach ($company->products as $product) {
                $product->temp_rates = $product->rates;
                $arr = [];
                foreach ($product->temp_rates->unique('term_id') as $item) {
                    $temp = $item->term->term;
                    $arr[] = $temp;
                }
                $product->terms = $arr;
                unset($product->temp_rates);
            }
        }
        return view('DhanBristi.create', compact(['products', 'companies']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (in_array('all', AgentCat())) {
            $companies = Company::orderBy('created_at', 'asc')->get();
        } else {
            $companies =  Company::whereIn('id', AgentCategories())->get();
        }
        $data = $request->input();
        //        try {

        $DBCalc = new DhanBristi;
        $DBCalc->age = $data['age'];
        $DBCalc->term = $data['term'];
        $DBCalc->sum_assured = $data['sum_assured'];
        $DBCalc->company_id = $data['company_id'];
        $DBCalc->product_id = $data['product_id'];
        $DBCalc->loadingCharge = $data['loading_charge_id'];
        $DBCalacTerm = $data['term'];


        $policyagerate = Policy_age::where('age', '=', $request->age)->first();
        $term = Term::where('term', '=', $DBCalacTerm)->first();

        $counter = PaybackSchedule::pluck('payback_year');

        /**
         * Main Calculation
         */
        $termRiderTR = Term_rider::where('age_id', $policyagerate->id)->where('term_id', $term->id)->pluck('rate')->first();
        $countRate = count($counter);
        $paymentMBSchedule = [];
        $tableRate = Rate_endowment::where('age_id', '=', $policyagerate->id)->where('term_id', '=', $term->id)->where('company_id', '=', $request->company_id)->where('product_id', '=', $request->product_id)->get()->pluck('rate')->first();
        $aDB = 1 / 1000;

        $newRate = $tableRate;
        $premiumAmount = ($newRate / 1000) * ($DBCalc->sum_assured);
        $accBenefit = $aDB * ($DBCalc->sum_assured);
        $trAmount = ($termRiderTR / 1000) * 400000;
        $totalPremium = $premiumAmount + $accBenefit + $trAmount;

        /**
         * Selected Company and Product Info
         */
        $company = Company::where('id', $data['company_id'])->first();
        $product = Product::where('id', $data['product_id'])->first();

        /**
         * List of all available companies
         */
        $companies = Company::orderBy('created_at', 'asc')->get();

        foreach ($companies as $comp) {
            $comp->products = $comp->dhan_bristi();
            foreach ($comp->products as $pro) {
                $pro->temp_rates = $pro->rates;
                $arr = [];
                foreach ($pro->temp_rates->unique('term_id') as $item) {
                    $temp = $item->term->term;
                    $arr[] = $temp;
                }
                $pro->terms = $arr;
                unset($pro->temp_rates);
            }
        }

        /**
         * Bonus rate calculation
         */
        $bonus = BonusRateEP::where('product_id', $data['product_id'])
            ->where('company_id', $data['company_id'])
            ->select('term_rate as rate')
            ->first();
        if ($bonus) {
            $bonus->yearly = (int)$data['sum_assured'] * $bonus->rate;
            $bonus->endOfPeriod = $bonus->yearly * (int)$data['term'];
            $bonus->total = $bonus->endOfPeriod + (int)$data['sum_assured'];
        } else {
            $bonus = collect();
            $bonus->rate = 'N/A';
            $bonus->yearly = 'N/A';
            $bonus->endOfPeriod = 'N/A';
            $bonus->total = 'N/A';
        }

        /**
         * Payback schedule table with amount
         */
        $paybackSchedule = PaybackSchedule::where('term_year', $DBCalacTerm)
            ->where('company_id', $request->company_id)
            ->where('product_id', $request->product_id)
            ->select('payback_year', 'rate')
            ->get();

        foreach ($paybackSchedule as $payback) {
            $payback->amount = $data['sum_assured'] * ($payback->rate / 100);
        }

        return view('DhanBristi.result')
            ->with('age', $DBCalc->age)
            ->with('term', $DBCalc->term)
            ->with('sum_assured', $DBCalc->sum_assured)
            ->with('tableRate', $tableRate)
            ->with('aDB', $aDB)
            ->with('termRiderTR', $termRiderTR)
            ->with('newRate', $newRate)
            ->with('premiumAmount', $premiumAmount)
            ->with('accBenefit', $accBenefit)
            ->with('trAmount', $trAmount)
            ->with('totalPremium', $totalPremium)
            ->with('bonus', $bonus)
            ->with('paybackSchedule', $paybackSchedule)
            ->with('counter', $countRate)
            ->with('paymentMBSchedule', $paymentMBSchedule)
            ->with('companies', $companies)
            ->with('company', $company)
            ->with('product', $product);

        //        } catch (Exception $e) {
        //            return back()->with('failed', 'Failed to retrive data!');
        //        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\DhanBristi $dhanBristi
     * @return \Illuminate\Http\Response
     */
    public function show(DhanBristi $dhanBristi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\DhanBristi $dhanBristi
     * @return \Illuminate\Http\Response
     */
    public function edit(DhanBristi $dhanBristi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DhanBristi $dhanBristi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DhanBristi $dhanBristi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\DhanBristi $dhanBristi
     * @return \Illuminate\Http\Response
     */
    public function destroy(DhanBristi $dhanBristi)
    {
        //
    }
}
