<?php

namespace App\Http\Controllers;

use App\Models\BonusRateEP;
use App\Models\Company;
use App\Models\CoupleAgeDifference;
use App\Models\CrcRate;
use App\Models\Feature;
use App\Models\GeneralSetting;
use App\Models\LoadingCharge;
use App\Models\PaybackSchedule;
use App\Models\Policy_age;
use App\Models\Product;
use App\Models\ProductFeature;
use App\Models\ProductFeatureRates;
use App\Models\Rate_endowment;
use App\Models\SumAssured;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Exception;

class LifeCalculatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function validateRate(Request $request)
    {
        return response()->json([
            'status' => 'ok',
            'output' => $request->all()
        ], 200);
    }

    public function index()
    {
        $data['companies'] = $this->getRequiredData();
        return view('Backend.Life.form', $data);
    }

    public function findFeature(Request $request)
    {
//        return $request;
        $featureIds = ProductFeature::where('product_id', $request->id)->pluck('feature_id');
        $data = Feature::whereIn('id', $featureIds)->get();
        $features = ProductFeature::where('product_id', $request->id)->with('feature')->get();
//dd($feature);
        $data = [];

        foreach ($features as $feature){
//            dd($feature);
            if($feature->feature) {
                $data[] = collect([
                    'id' => $feature->feature->id,
                    'code' => $feature->feature->code,
                    'name' => $feature->feature->name,
                    'is_compulsory' => $feature->is_compulsory,
                ]);
            }
        }

        return response()->json(array('success' => true, 'data' => $data));
        // return Response()::json(array('success' => true, 'data' => $data));
    }

    public function validateData(Request $request)
    {
        // Company Validation
        $data['company'] = Company::select('id', 'name', 'code')
            ->whereId($request->company)
            ->first();

        if (!$data['company']) {
            return $this->sendValidationResponse('Please select a company.', 'company');
        }
        // End of Company Validation

        // Product Validation
        $data['product'] = Product::whereId($request->product)
            ->first();

        if (!$data['product']) {
            return $this->sendValidationResponse('Please select a product.', 'product');
        }
        // End of Product Validation

        // Term Validation
        if (!$request->term) {
            return $this->sendValidationResponse('Please select a term.', 'term');
        }

        $data['termValue'] = $request->term;
        $data['term'] = Term::where('term', $data['termValue'])->first();

        if (!$data['term']) {
            return $this->sendValidationResponse('The selected term is invalid', 'term');
        }
        // End of Term Validation

        // Age Validation
        $data['plan'] = $data['product']->category;

//        $maturity_age = $data['term'];

        // in case of couple plan
        if ($data['plan'] == 'couple') {
            if (!$request->husband_age) {
                return $this->sendValidationResponse('Please enter the husband age.', 'husband_age');
            }

            if($data['product']->min_maturity_age && ($request->husband_age  + $data['termValue']) < $data['product']->min_maturity_age){
                return $this->sendValidationResponse('The selected age and term must be greater than ' . $data['product']->min_maturity_age , 'maturity_age');
            }

            if($data['product']->max_maturity_age && ($request->husband_age  + $data['termValue']) > $data['product']->max_maturity_age){
                return $this->sendValidationResponse('The selected age and term must be less than ' . $data['product']->max_maturity_age , 'maturity_age');
            }

            if (!$request->wife_age) {
                return $this->sendValidationResponse('Please enter the wife age.', 'wife_age');
            }

            if($data['product']->min_maturity_age && ($request->wife_age + $data['termValue']) < $data['product']->min_maturity_age){
                return $this->sendValidationResponse('The selected age and term must be greater than ' . $data['product']->min_maturity_age , 'maturity_age');
            }

            if($data['product']->max_maturity_age && ($request->wife_age  + $data['termValue']) > $data['product']->max_maturity_age){
                return $this->sendValidationResponse('The selected age and term must be less than ' . $data['product']->max_maturity_age , 'maturity_age');
            }

            $data['husbandAge'] = $request->husband_age;
            $data['wifeAge'] = $request->wife_age;
            $ages = collect([$data['husbandAge'], $data['wifeAge']]);
            $addDifference = CoupleAgeDifference::select('add_age')
                ->whereAgeDifference($ages->max() - $ages->min())
                ->first();

            if ($addDifference) {
                $addAge = $addDifference->add_age;
                unset($addDifference);
            } else {
                return $this->sendValidationResponse('The age difference data is missing.', 'couple_age');
            }

            $data['averageAge'] = $ages->min() + $addAge;
            unset($addAge);

            $data['age'] = Policy_age::where('age', $data['averageAge'])->first();
        } else {
            if ($data['plan'] == 'children' || $data['plan'] == 'education') {
                if (!isset($request->child_age)) {
                    return $this->sendValidationResponse('Please enter a child age.', 'child_age');
                }

                if($data['product']->min_maturity_age && ($request->child_age  + $data['termValue']) < $data['product']->min_maturity_age){
                    return $this->sendValidationResponse('The selected age and term must be greater than ' . $data['product']->min_maturity_age , 'maturity_age');
                }

                if($data['product']->max_maturity_age && ($request->child_age  + $data['termValue']) > $data['product']->max_maturity_age){
                    return $this->sendValidationResponse('The selected age and term must be less than ' . $data['product']->max_maturity_age , 'maturity_age');
                }

                $data['childAge'] = $request->child_age;
                $data['proposerAge'] = $request->proposer_age;
                $data['ageValue'] = $data['childAge'];
            } else {
                if (!$request->age) {
                    return $this->sendValidationResponse('Please enter an age.', 'age');
                }

                if ($request->age < 1) {
                    return $this->sendValidationResponse('The age must be greater than zero.', 'age');
                }

                if($data['product']->min_maturity_age && ($request->age  + $data['termValue']) < $data['product']->min_maturity_age){
                    return $this->sendValidationResponse('The selected age and term must be greater than ' . $data['product']->min_maturity_age , 'maturity_age');
                }
                if($data['product']->max_maturity_age && ($request->age  + $data['termValue']) > $data['product']->max_maturity_age){
                    return $this->sendValidationResponse('The selected age and term must be less than ' . $data['product']->max_maturity_age , 'maturity_age');
                }

                $data['ageValue'] = $request->age;
            }

            $data['age'] = Policy_age::where('age', $data['ageValue'])->first();
        }

        if (!$data['age']) {
            return $this->sendValidationResponse('The entered age is invalid.', 'age');
        }
        // End of Age Validation

        // Table Rate Validation
        $tableRate = Rate_endowment::whereAgeId($data['age']->id)
            ->whereTermId($data['term']->id)
            ->whereCompanyId($data['company']->id)
            ->whereProductId($data['product']->id)
            ->first();

        if (!$tableRate) {
            return $this->sendValidationResponse('No Table rate found. The age or term is invalid.', 'table_rate');
        }
        // end of  Table Rate Validation

        // Sum Assured Validation
        if (!$request->sum_assured) {
            return $this->sendValidationResponse('Please enter sum to be assured.', 'sum_assured');
        }

        if ($data['product']->min_sum && $request->sum_assured < $data['product']->min_sum) {
            return $this->sendValidationResponse('The sum assured must be greater than ' . $data['product']->min_sum, 'sum_assured');
        }

        if ($data['product']->max_sum && $request->sum_assured > $data['product']->max_sum) {
            return $this->sendValidationResponse('The sum assured must be less than ' . $data['product']->max_sum, 'sum_assured');
        }
        // end of Sum Assured Validation

        // MOP Validation
        if (!$request->loading_charge) {
            return $this->sendValidationResponse('Please select a MoP.', 'mop');
        }

        $loadingCharge = LoadingCharge::whereCompanyId($data['company']->id)
            ->whereProductId($data['product']->id)
            ->first();

        if (!$loadingCharge) {
            return $this->sendValidationResponse('The Loading Charge on MoP is missing. Please Insert the relevant data.', 'mop');
        }
        // End of MOP Validation

        return response()->json([
            'message' => 'All data is valid.',
            'type' => 'success'
        ], 200);
    }

    public function calculate(Request $request)
    {
        try {
            if (in_array('all', AgentCat())) {
                $companies = Company::orderBy('created_at', 'asc')->get();
            } else {
                $companies = Company::whereIn('id', AgentCategories())->get();
            }

            // retrieving all settings data
            $settings = GeneralSetting::whereType('calculation')->get()->pluck('value', 'key');

            // preparing data or calculation
            $data['company'] = Company::select('id', 'name', 'code')->whereId($request->company)->first();

            // checking if LIC is selected in company list
            $data['caseLIC'] = $data['company']->code == 'LIC';

            $data['caseNLIC'] = $data['company']->code == 'NLIC';

            $data['caseNational'] = $data['company']->code == 'NAT';

            $data['product'] = Product::whereId($request->product)->first();

            $data['plan'] = $data['product']->category;

            // in case of child plan
            if ($data['plan'] == 'children') {
                $data['childAge'] = $request->child_age;
                $data['proposerAge'] = $request->proposer_age;
                $data['actualTermValue'] = $request->term - $data['childAge'];
                $data['termValue'] = $request->term;
            } elseif ($data['plan'] == 'education') {
                $data['childAge'] = $request->child_age;
                $data['proposerAge'] = $request->proposer_age;
                $data['actualTermValue'] = $request->term;
                $data['termValue'] = $request->term;
            } else {
                $data['termValue'] = $request->term;
                $data['actualTermValue'] = $data['termValue'];
            }

            $data['term'] = Term::where('term', $data['termValue'])->first();

            $data['sumAssured'] = $request->sum_assured;
            $data['loadingChargeType'] = $request->loading_charge;
            $data['features'] = $request->features;
            // dd($data['features']);


            // in case of couple plan
            if ($data['plan'] == 'couple') {
                $data['husbandAge'] = $request->husband_age;
                $data['wifeAge'] = $request->wife_age;
                $ages = collect([$data['husbandAge'], $data['wifeAge']]);
                $addDifference = CoupleAgeDifference::select('add_age')
                    ->whereAgeDifference($ages->max() - $ages->min())
                    ->first();

                if ($addDifference) {
                    $addAge = $addDifference->add_age;
                    unset($addDifference);
                } else {
                    Session::flash('errorMessage', 'The age difference data is missing');
                    return back()->withInput();
                }

                $data['averageAge'] = $ages->min() + $addAge;
                unset($addAge);

                $data['age'] = Policy_age::where('age', $data['averageAge'])->first();
            } else {
                if ($data['plan'] == 'children' || $data['plan'] == 'education') {
                    $data['ageValue'] = $data['childAge'];
                } else {
                    $data['ageValue'] = $request->age;
                }

                $data['age'] = Policy_age::where('age', $data['ageValue'])->first();
            }

            // getting table rate according to age and term
            $tableRate = Rate_endowment::whereAgeId($data['age']->id)
                ->whereTermId($data['term']->id)
                ->whereCompanyId($data['company']->id)
                ->whereProductId($data['product']->id)
                ->first();

            $data['tableRate'] = $tableRate->rate;
            unset($tableRate);


            //preparing loading charge on MOP data
            $loadingCharge = LoadingCharge::whereCompanyId($data['company']->id)
                ->whereProductId($data['product']->id)
                ->first();
            // dd($loadingCharge);


            if (!$loadingCharge) {
                Session::flash('errorMessage', 'Loading Charge on MoP is missing');
                return back()->withInput();
            } else {

                if ($loadingCharge[$data['loadingChargeType']] === null) {
                    Session::flash('errorMessage', 'Invalid Loading Charge');
                    return back()->withInput();
                }
                $data['loadingCharge'] = $loadingCharge[$data['loadingChargeType']];
            }

            // Loading charge case of LIC
            if ($data['caseLIC']) {
                // if loading charge is not NIL(0) then loading charge rate is calculated (loadingCharge_rate = table_rate * loadingCharge)
                // if loading charge is NIL(0) then table rate is loading charge rate (loadingCharge_rate = table_rate)
                $data['loadingChargeRate'] = $data['loadingCharge'] ? $data['tableRate'] * $data['loadingCharge'] : $data['tableRate'];
            }

            //preparing discount on SA data according to product & requested sum assured amount
            $discountOnSA = SumAssured::where('first_amount', '<=', $data['sumAssured'])
                ->where('second_amount', '>=', $data['sumAssured'])
                ->whereCompanyId($data['company']->id)
                ->whereProductId($data['product']->id)
                ->first();

            $data['discountOnSA'] = $discountOnSA ? $discountOnSA->discount_value : 0;
            unset($discountOnSA);

            if ($data['product']->code == 'NAT_9' && $data['sumAssured'] >= 1000000) {
                $data['discountOnSA'] = 0;
            }

            //calculating new rate
            $data['newRate'] = ($data['caseLIC'] ? $data['loadingChargeRate'] : $data['tableRate']) - $data['discountOnSA'];

            //calculating premium amount
            $data['premiumAmount'] = ($data['newRate'] / $data['product']->premium_rate_divider) * $data['sumAssured'];

            if ($data['product']->code == 'NAT_9' && $data['sumAssured'] >= 1000000) {
                $data['premiumBeforeDiscount'] = $data['premiumAmount'];
                $data['discountOnPremium'] = (2 / 100) * $data['premiumAmount'];
                $data['premiumAmount'] -= $data['discountOnPremium'];
            } else {
                $data['discountOnPremium'] = null;
            }
            // compare upto here added

            if (!$data['caseLIC']) {
                //getting premium amount before discount in case of NLIC
                $data['premiumBeforeCharge'] = $data['premiumAmount'];
                //calculating loading charge or discount on MOP
                $data['loadingChargeAmount'] = ($data['loadingCharge'] / $settings['hundreds']) * $data['premiumBeforeCharge'];
                //calculating premium amount after discount
                $data['premiumAmount'] = $data['premiumBeforeCharge'] + $data['loadingChargeAmount'];
            }

            $data['totalPremiumAmount'] = $data['premiumAmount'];

            $data['features'] = $request->features;

            $data = $this->calculateFeatures($data, $settings);

            // in case of child crc rate is applied
            if (($data['plan'] == 'children' || $data['plan'] == 'education')) {
                $crcRate = CrcRate::whereAgeId($data['age']->id)
                    ->whereCompanyId($data['company']->id)
                    ->whereProductId($data['product']->id)
                    ->first();

                $data['crcRate'] = $crcRate ? $crcRate->one_time_charge : 0;

                $data['crcAmount'] = $data['crcRate'] / $settings['thousands'] * $data['sumAssured'];
//            $data['PremiumAmount'] = $data['totalPremiumAmount'];
//            $data['totalPremiumAmount'] += $data['crcAmount'];

            } else {
                $data['crcRate'] = 0;
            }

            // calculation bonus
            $data = $this->calculateBonus($data);

            // in case money back plan calculating bonus
            if ($data['plan'] == 'money-back' || $data['plan'] == 'dhan-bristi') {
                $data = $this->calculatePaybackSchedule($data);
            }

            $data['companies'] = $this->getRequiredData();

            unset($settings);

            return view('Backend.Life.result', $data);
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

    private function calculateFeatures($data, $settings)
    {
        $features = $data['features'];
        if ($features && count($features)) {
            foreach ($features as $featureCode) {
                $termId = $data['term']->id;
                $ageId = $data['age']->id;

                if (($data['plan'] == 'children' || $data['plan'] == 'education')) {
                    if ($data['caseLIC']) {
                        $termId = Term::where('term', $data['actualTermValue'])->first()->id;
                    }
                    $ageId = Policy_age::where('age', $data['proposerAge'])->first()->id;
                }

                $featureRow = Feature::whereCode($featureCode)->first();

                $featureRateRow = ProductFeatureRates::whereAgeId($ageId)
                    ->whereTermId($termId)
                    ->whereProductFeatureId(
                        ProductFeature::whereProductId($data['product']->id)
                            ->whereFeatureId($featureRow->id)
                            ->first()->id
                    )
                    ->first();

                $data[$featureCode . 'Rate'] = $featureRateRow ? $featureRateRow->rate : 0;

                if ($featureCode == 'pwb' && ($data['plan'] == 'children' || $data['plan'] == 'education')) {
                    $data[$featureCode . 'Amount'] = $data[$featureCode . 'Rate'] / $settings['hundreds'] * ($data['caseLIC'] ? $data['premiumAmount'] : $data['premiumBeforeCharge']);
                }
                elseif ($featureCode == 'term_rider') {
                    if ($data['caseNational'] && $data['sumAssured'] > $settings['term_rider_national']) {
                        $data[$featureCode . 'Amount'] = $data[$featureCode . 'Rate'] / $settings['thousands'] * $settings['term_rider_national'];
                    } elseif ($data['caseLIC'] && $data['sumAssured'] > $settings['term_rider']) {
                        $data[$featureCode . 'Amount'] = $data[$featureCode . 'Rate'] / $settings['thousands'] * $settings['term_rider'];
                    } else {
                        $data[$featureCode . 'Amount'] = $data[$featureCode . 'Rate'] / $settings['thousands'] * $data['sumAssured'];
                    }
                } else {
                    $data[$featureCode . 'Amount'] = $data[$featureCode . 'Rate'] / $settings['thousands'] * $data['sumAssured'];
                }
//                elseif ($featureCode == 'term_rider') {
//                    if ($data['sumAssured'] > $settings['term_rider']) {
//                        $data[$featureCode . 'Amount'] = $data[$featureCode . 'Rate'] / $settings['thousands'] * $settings['term_rider'];
//                    } else {
//                        $data[$featureCode . 'Amount'] = $data[$featureCode . 'Rate'] / $settings['thousands'] * $data['sumAssured'];
//                    }
//                }elseif ($featureCode == 'term_rider' && $data['caseNational']) {
//                    if ($data['sumAssured'] > $settings['term_rider_national']) {
//                        $data[$featureCode . 'Amount'] = $data[$featureCode . 'Rate'] / $settings['thousands'] * $settings['term_rider_national'];
//                    } else {
//                        $data[$featureCode . 'Amount'] = $data[$featureCode . 'Rate'] / $settings['thousands'] * $data['sumAssured'];
//                    }
//                }
//                else {
//                    $data[$featureCode . 'Amount'] = $data[$featureCode . 'Rate'] / $settings['thousands'] * $data['sumAssured'];
//                }

                $data['totalPremiumAmount'] += $data[$featureCode . 'Amount'];
//dd($data['product']);
                if ($data['product']->has_loading_charge_on_features) {
//                    dd('here');
                    $data[$featureCode . 'RateWithMop'] = ($data['loadingCharge'] / $settings['hundreds']) * $data[$featureCode . 'Amount'];
                    $data[$featureCode . 'AmountWithMop'] = $data[$featureCode . 'RateWithMop'] + $data[$featureCode . 'Amount'];
                    $data['totalPremiumAmount'] += $data[$featureCode . 'RateWithMop'];
                }

            }
        }

        if (array_key_exists('adbRate', $data) && array_key_exists('ptd_pwbRate', $data)) {
            $data['adbPwbPtdRate'] = $data['adbRate'] + $data['ptd_pwbRate'];
            $data['adbPwbPtdAmount'] = $data['adbAmount'] + $data['ptd_pwbAmount'];

            unset($data['adbRate']);
            unset($data['adbAmount']);
            unset($data['ptd_pwbRate']);
            unset($data['ptd_pwbAmount']);

            unset($data['features'][array_search('adb', $data['features'])]);
            unset($data['features'][array_search('ptd_pwb', $data['features'])]);
        }

//        if (array_key_exists('husband_adbRate', $data) && array_key_exists('wife_adbRate', $data)) {
//            $data['couple_adbRate'] = $data['husband_adbRate'] + $data['wife_adbRate'];
//            $data['couple_adbAmount'] = $data['husband_adbAmount'] + $data['wife_adbAmount'];
//
//            $data['coupleRateWithMop'] = $data['husband_adbRateWithMop'] + $data['wife_adbRateWithMop'];
//            $data['coupleAmountWithMop'] = $data['husband_adbAmountWithMop'] + $data['wife_adbAmountWithMop'];
//
//            unset($data['husband_adbRate']);
//            unset($data['husband_adbAmount']);
//            unset($data['wife_adbRate']);
//            unset($data['wife_adbAmount']);
//
//            unset($data['features'][array_search('husband_adb', $data['features'])]);
//            unset($data['features'][array_search('wife_adb', $data['features'])]);
//        }

        return $data;
    }

    private function calculatePaybackSchedule($data)
    {
        // Payback schedule with amount
        $paybackSchedule = PaybackSchedule::whereTermYear($data['termValue'])
            ->whereCompanyId($data['company']->id)
            ->whereProductId($data['product']->id)
            ->select('payback_year', 'rate')
            ->get();

        foreach ($paybackSchedule as $payback) {
            $payback->amount = $data['sumAssured'] * ($payback->rate / 100);
        }

        $data['paybackSchedule'] = $paybackSchedule;
        unset($paybackSchedule);

        return $data;
    }

    private function calculateBonus($data)
    {

        // Bonus rate calculation
        $bonus = BonusRateEP::select('term_rate as rate')
            ->where('first_year', '<=', $data['termValue'])
            ->where('second_year', '>=', $data['termValue'])
            ->whereProductId($data['product']->id)
            ->whereCompanyId($data['company']->id)
            ->first();

        if ($bonus) {
            $bonus->yearly = (int)$data['sumAssured'] * $bonus->rate;
            if (($data['plan'] == 'children' || $data['plan'] == 'education') && $data['caseLIC']) {
                $bonus->endOfPeriod = $bonus->yearly * (int)$data['actualTermValue'];
            } else {
                $bonus->endOfPeriod = $bonus->yearly * (int)$data['termValue'];
            }
            $bonus->total = $bonus->endOfPeriod + (int)$data['sumAssured'];
        } else {
            $bonus = collect();
            $bonus->rate = 'N/A';
            $bonus->yearly = 'N/A';
            $bonus->endOfPeriod = 'N/A';
            $bonus->total = 'N/A';
        }

        $data['bonus'] = $bonus;
        unset($bonus);

        return $data;
    }

    private function getRequiredData()
    {
        if (in_array('all', AgentCat())) {
            $companies = Company::orderBy('created_at', 'asc')->get();
        } else {
            $companies = Company::whereIn('id', AgentCategories())->get();
        }

        // retrieving companies (optimizing query with only selecting id and name)
        $companies = Company::select('id', 'name', 'code')
            ->where('is_active', '1')
            ->where('type', 'life')
            ->with(['products' => function ($query) {
                $query->whereIsActive(true)
                    ->select('id', 'name', 'company_id', 'category');
            }])
            ->whereHas('products')
            ->orderBy('name', 'asc')
            ->get();


        // looping through retrieved companies
        foreach ($companies as $company) {

            // looping through retrieved products
            foreach ($company->products as $product) {

                // temp_rates is for temporary use
                // retrieving Rate_endowment list related to the product (through relation)
                $product->temp_rates = $product->rates;

                // creating an empty array to store terms
                $termArray = [];
                $ageArray = [];
                $proposerAgeArray = [];

                // looping rates (of only unique terms)
                foreach ($product->temp_rates->unique('term_id') as $rate) {
                    // pushing term value to array
                    // accessing term column of term table through rate_endowment
                    $termArray[] = $rate->term->term;
                }
                // setting terms in product
                $product->terms = $termArray;
                unset($termArray);

                foreach ($product->temp_rates->unique('age_id') as $ageRate) {
                    $ageArray[] = $ageRate->age->age;
                }
                $product->ages = $ageArray;
                $ageCollect = collect($ageArray);
                unset($ageArray);


                if ($company->code == 'NAT') {
                    $term_rider = Feature::whereCode('term_rider')->first();
                    $product_feature = ProductFeature::whereFeatureId($term_rider->id)->whereProductId($product->id)->first();
                } else {
                    $pwb = Feature::whereCode('pwb')->first();
                    $product_feature = ProductFeature::whereFeatureId($pwb->id)->whereProductId($product->id)->first();
                }

                if ($product_feature) {
                    foreach ($product_feature->rates->unique('age_id') as $item) {
                        $proposerAgeArray[] = $item->age->age;
                    }
//                    dd($product);
                }

                $product->proposer_ages = $proposerAgeArray;

                $product->max_age = $ageCollect->max();
                $product->min_age = $ageCollect->min();
                unset($ageCollect);

                unset($product->rates);
                unset($product->temp_rates);
            }
        }

        return $companies;
    }

    private function sendValidationResponse($message, $type)
    {
        return response()->json([
            'message' => $message,
            'type' => $type
        ], 422);
    }
}
