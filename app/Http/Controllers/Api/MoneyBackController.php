<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BonusRateEP;
use App\Models\Company;
use App\Models\MoneyBack;
use App\Models\PaybackSchedule;
use App\Models\Policy_age;
use App\Models\Product;
use App\Models\Rate_endowment;
use App\Models\SumAssured;
use App\Models\Term;
use App\Models\Term_rider;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MoneyBackController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create()
    {
        // $products = Product::where('category', 'money-back')->get();
        $companies = Company::orderBy('created_at', 'asc')
            ->select('id', 'name', 'code')
            ->get();

        foreach ($companies as $company) {
            $company->products = $company->money_back();
            foreach ($company->products as $product) {
                $product->temp_rates = $product->rates;
                $arr = [];
                foreach ($product->temp_rates->unique('term_id') as $item) {
                    $temp = $item->term->term;
                    $arr[] = $temp;
                }
                $product->terms = $arr;
                unset($product->temp_rates);
                unset($product->rates);
                unset($product->created_at);
                unset($product->updated_at);
                unset($product->type);
            }
        }

        return response()->json([
            "data" => [
                "companies" => $companies
            ],
            "success" => true
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->input();
        //        try {
        $moneyBackCalc = new MoneyBack;
        $moneyBackCalc->age = $data['age'];
        $moneyBackCalc->term = $data['term'];
        $moneyBackCalc->sum_assured = $data['sum_assured'];
        $moneyBackCalc->loadingCharge = $data['loading_charge_id'];
        $moneyBackCalc->company_id = $data['company_id'];
        $moneyBackCalc->product_id = $data['product_id'];


        $moneyBackTerm = $data['term'];

        $paybackYear = PaybackSchedule::where('company_id', $moneyBackCalc->company_id)->where('product_id', $request->product_id)->get()->pluck('payback_year');

        $policyagerate = Policy_age::where('age', '=', $request->age)->first();
        $term = Term::where('term', '=', $moneyBackTerm)->first();

        $termDB = Rate_endowment::where('age_id', '=', $policyagerate->id)->where('term_id', '=', $term->id)->where('company_id', '=', $request->company_id)->where('product_id', '=', $request->product_id)->get()->pluck('rate')->first();

        $termRiderTR = Term_rider::where('age_id', $policyagerate->id)->where('term_id', $term->id)->pluck('rate')->first();

        $discount = SumAssured::where('first_amount', '<=', $request->sum_assured)->where('second_amount', '>=', $request->sum_assured)->pluck('discount_value');
        $discountonSA = $discount[0];

        $countRate = count($paybackYear);
        $aDB = 1 / 1000;

        $tableRate = $termDB;
        $newRate = $tableRate - $discountonSA;
        $premiumAmount = ($newRate / 1000) * ($moneyBackCalc->sum_assured);
        $accBenefit = $aDB * ($moneyBackCalc->sum_assured);
        $trAmount = $termRiderTR * (400000 / 1000);
        $totalPremium = $premiumAmount + $accBenefit + $trAmount;

        /**
         * Selected Company and Product Info
         */
        $company = Company::where('id', $data['company_id'])
            ->select('id', 'name', 'code')
            ->first();
        $product = Product::where('id', $data['product_id'])
            ->select('id', 'name', 'code', 'company_id', 'category')
            ->first();

        /**
         * List of all available companies
         */
        $companies = Company::orderBy('created_at', 'asc')
            ->select('id', 'name', 'code')
            ->get();
        foreach ($companies as $comp) {
            $comp->products = $comp->money_back();
            foreach ($comp->products as $pro) {
                $pro->temp_rates = $pro->rates;
                $arr = [];
                foreach ($pro->temp_rates->unique('term_id') as $item) {
                    $temp = $item->term->term;
                    $arr[] = $temp;
                }
                $pro->terms = $arr;
                unset($pro->temp_rates);
                unset($pro->rates);
                unset($pro->created_at);
                unset($pro->updated_at);
                unset($pro->type);
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
        $paybackSchedule = PaybackSchedule::where('term_year', $data['term'])
            ->where('company_id', $request->company_id)
            ->where('product_id', $request->product_id)
            ->select('payback_year', 'rate')
            ->get();

        foreach ($paybackSchedule as $payback) {
            $payback->amount = $data['sum_assured'] * ($payback->rate / 100);
        }

        return response()->json([
            "data" => [
                'aDB' => $aDB,
                'tableRate' => $tableRate,
                'sum_assured' => $request->sum_assured,
                'term' => $request->term,
                'age' => $request->age,
                'termRiderTR' => $termRiderTR,
                'newRate' => $newRate,
                'premiumAmount' => $premiumAmount,
                'accBenefit' => $accBenefit,
                'trAmount' => $trAmount,
                'totalPremium' => $totalPremium,
                'bonus' => $bonus,
                'paybackSchedule' => $paybackSchedule,
                'counter' => $countRate,
                'companies' => $companies,
                'company' => $company,
                'product' => $product,
            ],
            "success" => false
        ], 400);
        //        } catch (Exception $e) {
        //            return response()->json([
        //                "data" => [
        //                    "message" => "Something went wrong. Please try again"
        //                ],
        //                "success" => false
        //            ], 400);
        //        }
    }
}
