<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use App\Models\BonusRateEP;
use App\Models\Company;
use App\Models\LoadingCharge;
use App\Models\PaybackSchedule;
use App\Models\Policy_age;
use App\Models\Product;
use App\Models\Rate_endowment;
use App\Models\SumAssured;
use App\Models\Term;
use App\Models\Term_rider;
use App\Models\WholeAdb;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MoneyBackCalcController extends Controller
{

    /**
     * @return Application|Factory|View
     */
    public function showCalculationForm()
    {
        $data['companies'] = $this->getRequiredData();

        return view('Backend.Life.MoneyBack.form', $data);
    }

    /**
     * @return mixed
     */
    public function getRequiredData()
    {
        if (in_array('all', AgentCat())) {
            $companies = Company::orderBy('created_at', 'asc')->get();
        } else {
            $companies =  Company::whereIn('id', AgentCategories())->get();
        }
        // retrieving companies (optimizing query with only selecting id and name)
        $companies = Company::select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();

        // looping through retrieved companies
        foreach ($companies as $companyData) {
            // retrieving products (of money back category) related to company (through relation)
            $companyData->products = $companyData->money_back();

            //getting benefits
            $companyData->benefits = Benefit::where('company_id', $companyData->id)
                ->where('category', 'money-back')
                ->pluck('name');

            // looping through retrieved products
            foreach ($companyData->products as $product) {
                // temp_rates is for temporary use
                // retrieving Rate_endowment list related to the product (through relation)
                $product->temp_rates = $product->rates;

                // creating an empty array to store terms
                $arr = [];

                // looping rates (of only unique terms)
                foreach ($product->temp_rates->unique('term_id') as $rate) {
                    // pushing term value to array
                    // accessing term column of term table through rate_endowment

                    // array_push($arr, $rate->term->term);
                    $arr[] = $rate->term->term;
                }

                // setting terms in product
                $product->terms = $arr;

                // retrieving adb_rate types related to the product
                $adbRatesTypes = WholeAdb::where('product_id', $product->id)
                    ->distinct('type')
                    ->pluck('type');

                // setting adb types in product
                $product->adb_types = $adbRatesTypes;

                //  removing unnecessary data
                unset($product->rates);
                unset($product->temp_rates);
            }
        }

        return $companies;
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function calculate(Request $request)
    {
        if (in_array('all', AgentCat())) {
            $companies = Company::orderBy('created_at', 'asc')->get();
        } else {
            $companies =  Company::whereIn('id', AgentCategories())->get();
        }
        /**
         * validating data
         */
        $request->validate([
            'company' => 'required',
            'product' => 'required',
            'age' => 'required',
            'term' => 'required',
            'sum_assured' => 'required',
            'loading_charge' => 'required',
            'benefits' => 'required',
        ]);

        /**
         * Preparing data for calculation
         */

        $data['company_id'] = $request->company;
        $data['product_id'] = $request->product;
        $data['age'] = $request->age;
        $data['term'] = $request->term;
        $data['sum_assured'] = $request->sum_assured;
        $data['loading_charge_type'] = $request->loading_charge;
        $data['benefits'] = $request->benefits;

        /**
         * store benefits amount if any selected
         */
        $data['benefitsAmount'] = [];

        /**
         * Selected Company and Product Info
         */
        $company = Company::where('id', $data['company_id'])->first();
        $product = Product::where('id', $data['product_id'])->first();

        /**
         * getting selected term details
         */
        $term = Term::where('term', $data['term'])->first();

        /**
         * getting selected age details
         */
        $age = Policy_age::where('age', $data['age'])->first();

        /**
         * preparing table rate according to age & term
         */
        $data['table_rate'] = Rate_endowment::where('age_id', '=', $age->id)
            ->where('term_id', '=', $term->id)
            ->where('company_id', '=', $data['company_id'])
            ->where('product_id', '=', $data['product_id'])
            ->first()
            ->rate;

        $isLIC = false;
        $isNLIC = false;

        if ($company->code == 'LIC') {
            $isLIC = true;
        } else {
            $isNLIC = true;
        }

        /**
         * preparing loading charge on MOP data
         */
        $data['loading_charge'] = LoadingCharge::where('company_id', '=', $data['company_id'])
            ->where('product_id', '=', $data['product_id'])
            ->pluck($data['loading_charge_type'])
            ->first();

        // Loading charge case of LIC
        if ($isLIC) {
            /**
             * if loading charge is not NIL(0) then loading charge rate is calculated (loading_charge_rate = table_rate * loading_charge)
             * if loading charge is NIL(0) then table rate is loading charge rate (loading_charge_rate = table_rate)
             */
            $data['loading_charge_rate'] = $data['loading_charge'] ? $data['table_rate'] * $data['loading_charge'] : $data['table_rate'];
        }

        /**
         * preparing discount on SA data according to product & requested sum assured amount
         */
        $data['discount_on_sa'] = SumAssured::where('first_amount', '<=', $data['sum_assured'])
            ->where('second_amount', '>=', $data['sum_assured'])
            ->where('company_id', '=', $data['company_id'])
            ->where('product_id', '=', $data['product_id'])
            ->first();

        /**
         * calculating discount on SA
         */
        $data['discount_on_sa'] = $data['discount_on_sa'] ? $data['discount_on_sa']->discount_value : 0;

        /**
         * calculating new rate
         */
        $data['new_rate'] = ($isLIC ? $data['loading_charge_rate'] : $data['table_rate']) - $data['discount_on_sa'];

        /**
         * calculating premium amount
         */
        $data['premium_amount'] = ($data['new_rate'] / 1000) * $data['sum_assured'];

        //Loading charge case if NLIC
        if ($isNLIC) {
            //getting premium amount before discount in case of nlic
            $data['premium_before_charge'] = $data['premium_amount'];
            //calculating loading charge or discount on MOP
            $data['loading_charge_amount'] = ($data['loading_charge'] / 100) * $data['premium_before_charge'];
            //calculating premium amount after discount
            $data['premium_amount'] = $data['premium_before_charge'] + $data['loading_charge_amount'];
        }

        if (in_array('ADB', $data['benefits'])) {
            /**
             * Preparing ADB Data
             */

            $data['adb_rate'] = WholeAdb::where('type', 'adb')
                ->where('company_id', '=', $data['company_id'])
                ->where('product_id', '=', $data['product_id'])
                ->first();

            $data['adb_rate'] = $data['adb_rate'] ? $data['adb_rate']->rate : 0;

            /**
             * Calculating ADB Amount if selected
             * * if not selected then it is 0
             */
            $data['adb_amount'] = ($data['adb_rate'] / 1000) * $data['sum_assured'];
        } else {
            $data['adb_amount'] = 0;
        }

        if (in_array('Term Rider', $data['benefits'])) {
            /**
             * Preparing Term Rider Data
             */

            $data['term_rider_rate'] = Term_rider::where('age_id', '=', $age->id)
                ->where('term_id', '=', $term->id)
                ->where('company_id', '=', $data['company_id'])
                ->where('product_id', '=', $data['product_id'])
                ->first();

            $data['term_rider_rate'] = $data['term_rider_rate'] ? $data['term_rider_rate']->rate : 0;

            /**
             * Calculating Term Rider Amount if selected
             * if not selected then it is 0
             */
            $data['term_rider_amount'] = ($data['term_rider_rate'] / 1000) * 400000;
        } else {
            $data['term_rider_amount'] = 0;
        }

        /**
         * Total Premium Amount After Benefits (if available)
         */
        $data['total_premium_amount'] = $data['premium_amount'] + $data['term_rider_amount'] +  $data['adb_amount'];

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
         * Payback schedule with amount
         */
        $paybackSchedule = PaybackSchedule::where('term_year', $data['term'])
            ->where('company_id', $data['company_id'])
            ->where('product_id', $data['product_id'])
            ->select('payback_year', 'rate')
            ->get();

        foreach ($paybackSchedule as $payback) {
            $payback->amount = $data['sum_assured'] * ($payback->rate / 100);
        }

        $data['payback_schedule'] = $paybackSchedule;

        /**
         * All Companies
         */
        $data['company'] = $company;
        $data['product'] = $product;
        $data['bonus'] = $bonus;
        $data['isLIC'] = $isLIC;
        $data['isNLIC'] = $isNLIC;
        $data['companies'] = $this->getRequiredData();

        return view('Backend.Life.MoneyBack.result', $data);
    }
    public function feature(Request $request)
    {
    }
}
