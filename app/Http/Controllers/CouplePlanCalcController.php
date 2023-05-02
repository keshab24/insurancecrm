<?php

namespace App\Http\Controllers;

use App\Models\BonusRateEP;
use App\Models\Company;
use App\Models\CoupleAgeDifference;
use App\Models\LoadingCharge;
use App\Models\PaybackSchedule;
use App\Models\Policy_age;
use App\Models\Product;
use App\Models\Rate_endowment;
use App\Models\SumAssured;
use App\Models\Term;
use App\Models\WholeAdb;
use Illuminate\Http\Request;

use function GuzzleHttp\Promise\each;

class CouplePlanCalcController extends Controller
{
    public function showCalculationForm()
    {
        $data['companies'] = $this->getRequiredData();

        return view('Backend.Life.CouplePlan.form', $data);
    }

    public function getRequiredData()
    {
        if (in_array('all', AgentCat())) {
            $companies = Company::orderBy('created_at', 'asc')->get();
        } else {
            $companies =  Company::whereIn('id', AgentCategories())->get();
        }
        //retriving companies
        $companies = Company::select('id', 'name')
            ->orderBy('name', 'asc')
            ->whereHas('products', function ($query) {
                $query->where('category', 'couple');
            })
            ->get();
        //looping through retrieved companies
        foreach ($companies as $companyData) {
            //retriving products related to company
            $companyData->products = $companyData->couple_plans();
            //looping through retrived products
            foreach ($companyData->products as $product) {
                //retriving table rate in temp_rates
                $product->temp_rates = $product->rates;
                //creating empty array to store
                $arr = [];
                //looping rates
                foreach ($product->temp_rates->unique('term_id') as $rate) {
                    // accessing term column of term table through rate_endowment (rate table)
                    $arr[] = $rate->term->term;
                }
                $product->terms = $arr;
                //removing temp data
                unset($product->rates);
                unset($product->temp_rates);
            }
        }
        return $companies;
    }

    public function calculate(Request $request)
    {
        if (in_array('all', AgentCat())) {
            $companies = Company::orderBy('created_at', 'asc')->get();
        } else {
            $companies =  Company::whereIn('id', AgentCategories())->get();
        }
        //validating data
        $request->validate([
            'company' => 'required',
            'product' => 'required',
            'husband_age' => 'required',
            'wife_age' => 'required',
            'term' => 'required',
            'sum_assured' => 'required',
            'loading_charge' => 'required',
        ]);

        //data for calculation
        $data['company_id'] = $request->company;
        $data['product_id'] = $request->product;
        $data['husband_age'] = $request->husband_age;
        $data['wife_age'] = $request->wife_age;
        $data['term'] = $request->term;
        $data['sum_assured'] = $request->sum_assured;
        $data['selected_benefit'] = $request->has('benefit') ? $request->benefit : [];
        $data['loading_charge_type'] = $request->loading_charge;

        //select company, product and term
        $data['company'] = Company::where('id', $data['company_id'])->first();
        $data['product'] = Product::where('id', $data['product_id'])->first();
        $term = Term::where('term', $data['term'])->first();

        //calculation for average age with reference to couple age difference table
        $ages = collect([$data['husband_age'], $data['wife_age']]);
        $add_age = CoupleAgeDifference::where('age_difference', $ages->max() - $ages->min())
            ->select('add_age')
            ->first()
            ->add_age;
        $data['average_age'] = $ages->min() + $add_age;

        $age = Policy_age::where('age', $data['average_age'])->first();

        //preparing table rate accourding to average_age & term
        $data['table_rate'] = Rate_endowment::where('age_id', '=', $age->id)
            ->where('term_id', '=', $term->id)
            ->where('company_id', '=', $data['company_id'])
            ->where('product_id', '=', $data['product_id'])
            ->first()
            ->rate;

        //preparing discount on SA data according to product & requested sum assured amount
        $data['discount_on_sa'] = SumAssured::where('first_amount', '<=', $data['sum_assured'])
            ->where('second_amount', '>=', $data['sum_assured'])
            ->where('company_id', '=', $data['company_id'])
            ->where('product_id', '=', $data['product_id'])
            ->first();
        $data['discount_on_sa'] = $data['discount_on_sa'] ? $data['discount_on_sa']->discount_value : 0;

        //calculating new rate
        $data['new_rate'] = $data['table_rate'] - $data['discount_on_sa'];

        //calculationg premium amount
        $data['premium_amount'] = ($data['new_rate'] / 1000) * $data['sum_assured'];

        //calculating discount/loadingcharge on MOP
        $data['loading_charge'] = LoadingCharge::where('company_id', $data['company_id'])
            ->where('product_id', $data['product_id'])
            ->pluck($data['loading_charge_type'])
            ->first();
        $data['mop_amount'] = ($data['loading_charge'] / 100) * $data['premium_amount'];

        //calculating premium after MOP
        $data['actual_premium'] = $data['premium_amount'] + $data['mop_amount'];

        //calculating adb of husband and wife
        $data['husband_adb'] = in_array('husband_adb', $data['selected_benefit']) ? 1 : 0;
        $data['wife_adb'] = in_array('wife_adb', $data['selected_benefit']) ? 1 : 0;
        $data['total_adb'] = $data['husband_adb'] + $data['wife_adb'];
        $data['adb_amount'] = ($data['total_adb'] / 1000) * $data['sum_assured'];

        //calculating premium after adb
        $data['total_premium_amount'] = $data['actual_premium'] + $data['adb_amount'];

        if ($data['loading_charge_type'] !== 'yearly') {
            $data['half_yearly_premium_amount'] = $data['total_premium_amount'] / 2;
        } else {
            $data['half_yearly_premium_amount'] = 0;
        }

        //bonus rate calculation
        $bonus = BonusRateEP::where('product_id', $data['product_id'])
            ->where('company_id', $data['company_id'])
            ->select('term_rate as term')
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
        $data['bonus'] = $bonus;
        $data['companies'] = $this->getRequiredData();

        return view('Backend.Life.CouplePlan.result', $data);
    }
}
