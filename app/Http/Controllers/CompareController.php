<?php

namespace App\Http\Controllers;

use App\Mail\CompareResult;
use App\Models\BonusRateEP;
use App\Models\Company;
use App\Models\CoupleAgeDifference;
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
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Mail;
use PDF;
use Exception;

class CompareController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showCompareForm()
    {
        $data = $this->getRequiredData();

        return view('Backend.Compare.index', $data);
    }

    private function getRequiredData()
    {
        $data['ages'] = Policy_age::orderBy('age')
            ->where('age', '>', 0)
            ->get('age')
            ->unique('age')
            ->pluck('age');

        $data['terms'] = Term::orderBy('term')
            ->where('term', '>', 0)
            ->get('term')
            ->unique('term')
            ->pluck('term');

        $data['companies'] = Company::select('id', 'name')
            ->where('type', 'life')
            ->where('is_active', '1')
            ->with(['products' => function ($query) {
                $query->whereIsActive(true)
                    ->select('id', 'name', 'company_id', 'category');
            }])
            ->whereHas('products')
            ->orderBy('name', 'asc')
            ->get();

        $data['categories'] = Product::get()->unique('category')->pluck('category');

        $data['mops'] = GeneralSetting::where('type', 'mop')->pluck('value');

        $data['features'] = Feature::all();

        return $data;
    }

    public function addRow()
    {
        $selected = json_decode(request()->products);
        $data['id'] = request()->id;
        $data['companies'] = Company::select('id', 'name')
            ->where('type', 'life')
            ->where('is_active', '1')
            ->with(['products' => function ($query) use ($selected) {
                $query->whereIsActive(true)
                    ->whereNotIn('id', $selected)
                    ->select('id', 'name', 'company_id', 'category');
            }])
            ->whereHas('products')
            ->orderBy('name', 'asc')
            ->get();

        return view('Backend.Compare.add', $data)->render();
    }

    public function compare(Request $request)
    {
//        try {
        $data['clientName'] = $request->full_name;
        $data['clientEmail'] = $request->email;
        $data['selectedAge'] = $request->age;
        $data['selectedHusbandAge'] = $request->husband_age;
        $data['selectedWifeAge'] = $request->wife_age;
        $data['selectedChildAge'] = $request->child_age;
        $data['selectedProposersAge'] = $request->proposer_age;
        $data['selectedTerm'] = $request->term;
        $data['selectedCategory'] = $request->category;
        $data['selectedSumAssured'] = $request->sum_assured;
        $data['selectedMop'] = $request->mop;
        $data['selectedCompanies'] = $request->companies;
        $data['selectedProducts'] = $request->download_pdf ? json_decode($request->products) : $request->products;
        $data['features'] = $request->download_pdf ? json_decode($request->features) : $request->features;

        $data['isCouplePlan'] = $data['selectedCategory'] === 'couple';
        $data['isChildPlan'] = $data['selectedCategory'] === 'children' || $data['selectedCategory'] === 'education';

        if ($data['isCouplePlan']) {
            $ages = collect([$data['selectedHusbandAge'], $data['selectedWifeAge']]);
            $addDifference = CoupleAgeDifference::select('add_age')
                ->whereAgeDifference($ages->max() - $ages->min())
                ->first();

            if ($addDifference) {
                $addAge = $addDifference->add_age;
                unset($addDifference);
            } else {
                $addAge = 0;
            }

            $data['averageAge'] = $ages->min() + $addAge;
            unset($addAge);

            $data['age'] = Policy_age::where('age', $data['averageAge'])->first();
        } else {

            if ($data['isChildPlan']) {
                $data['selectedAge'] = $data['selectedChildAge'];
            }

            $data['age'] = Policy_age::whereAge($data['selectedAge'])->first();
        }

        if ($data['selectedCategory'] == 'children') {
            $data['actualTerm'] = $data['selectedTerm'] - $data['selectedChildAge'];
        } elseif ($data['selectedCategory'] == 'education') {
            $data['actualTerm'] = $data['selectedTerm'];
        } else {
            $data['actualTerm'] = $data['selectedTerm'];
        }

        $data['term'] = Term::whereTerm($data['selectedTerm'])->first();

        $data['products'] = $this->compareProducts($data);

        if ($request->download_pdf) {
//            return view('Backend.Compare.pdf', $data);
            $pdf = PDF::loadView('Backend.Compare.pdf', $data);

            // Send mail to customer
            Mail::to($data['clientEmail'])
                ->send(new CompareResult($data['products'], $data['clientName'], $pdf->output()));

            return $pdf->download('compare.pdf');
        }

        $data['totalMultiplier'] = 0;
//            for ($i=1;$i<=$data['selectedTerm'];$i++){
//                $data
//            }
        return view('Backend.Compare.result', $data);
//        } catch (Exception $e) {
//            return redirect()->back();
//        }
    }

    private function findRelevantTerm($currentTerm, $age, $product, $selectedTerm, $maxTermInDB)
    {
        if ($currentTerm <= $maxTermInDB) {
            $term = Term::where('term', $currentTerm)->first();

            $tableRate = Rate_endowment::whereAgeId($age->id)
                ->whereTermId($term->id)
                ->whereProductId($product->id)
                ->first();

            if (!$tableRate) {

                if ($currentTerm <= $selectedTerm && $currentTerm != 0) {
                    return $this->findRelevantTerm(--$currentTerm, $age, $product, $selectedTerm, $maxTermInDB);
                } else {
                    if ($currentTerm < $selectedTerm) {
                        $currentTerm = $selectedTerm;
                    }
                    return $this->findRelevantTerm(++$currentTerm, $age, $product, $selectedTerm, $maxTermInDB);
                }
            } else {
                return [$tableRate, $term];
            }
        } else {
            return null;
        }
    }

    private function findRelevantAge($currentAge, $product, $selectedAge, $maxAgeInDB)
    {
        if ($currentAge <= $maxAgeInDB) {
            $age = Policy_age::where('age', $currentAge)->first();

            $tableRate = Rate_endowment::whereAgeId($age->id)
                ->whereProductId($product->id)
                ->first();

            if (!$tableRate) {

                if ($currentAge <= $selectedAge && $currentAge != 0) {
                    return $this->findRelevantAge(--$currentAge, $product, $selectedAge, $maxAgeInDB);
                } else {
                    if ($currentAge < $selectedAge) {
                        $currentAge = $selectedAge;
                    }
                    return $this->findRelevantAge(++$currentAge, $product, $selectedAge, $maxAgeInDB);
                }
            } else {
                return $age;
            }
        } else {
            return null;
        }
    }

    private function compareProducts($data)
    {
        $productIDs = $data['selectedProducts'];
        $category = $data['selectedCategory'];
        $age = $data['age'];
        $term = $data['term'];
        $mop = $data['selectedMop'];
        $sum = $data['selectedSumAssured'];
        $maxAgeInDB = Policy_age::max('age');
        $maxTermInDB = Term::max('term');

        $settings = GeneralSetting::whereType('calculation')->get()->pluck('value', 'key');

        $products = Product::whereType('life')
            ->whereCategory($category)
            ->whereIsActive(true)
            ->whereIn('id', $productIDs)
            ->select('id', 'name', 'company_id')
            ->get();

        foreach ($products as $key => $product) {

            $product->isLic = $product->company->code == 'LIC';
            $product->isNational = $product->company->code == 'NAT';
            $product->isNlic = $product->company->code == 'NLIC';

            // table rates starts

            $age = $this->findRelevantAge($age->age, $product, $age->age, $maxAgeInDB);

            if ($age) {
                $product->currentAge = $age->age;
            } else {
                unset($products[$key]);
            }

            $arr = $this->findRelevantTerm($term->term, $age, $product, $term->term, $maxTermInDB);

            $tableRate = null;

            if ($arr) {
                $tableRate = $arr[0];
                $term = $arr[1];
                $product->currentTerm = $term->term;
            } else {
                unset($products[$key]);
            }

            if ($tableRate) {
                $product->rate = $tableRate->rate;
            } else {
                unset($products[$key]);
            }
            unset($tableRate);

            // loading charges starts
            $loadingCharge = LoadingCharge::whereProductId($product->id)->first();

            if ($loadingCharge) {
                $product->mop = $loadingCharge[$mop];
            } else {
                unset($products[$key]);
            }
            unset($loadingCharge);

            if ($product->isLic) {
                $product->mopRate = $product->mop ? $product->rate * $product->mop : $product->rate;
            }
            // loading charges ends

            // discount on sa starts
            $discountOnSA = SumAssured::where('first_amount', '<=', $sum)
                ->where('second_amount', '>=', $sum)
                ->whereProductId($product->id)
                ->first();

            $product->discountRate = $discountOnSA ? $discountOnSA->discount_value : 0;
            unset($discountOnSA);

            if ($product->isNational && $sum > 1000000) {
                $product->discountRate = 0;
            }
            // discount on sa ends

            // new rate
            $product->newRate = ($product->isLic ? $product->mopRate : $product->rate) - $product->discountRate;

            // premium calculation starts here
            $product->premiumAmount = ($product->newRate / $settings['thousands']) * $sum;

            if ($product->isNational && $sum > 1000000) {
                $product->premiumBeforeDiscount = $product->premiumAmount;
                $product->discountOnPremium = (2 / $settings['hundreds']) * $product->premiumAmount;
                $product->premiumAmount -= $product->discountOnPremium;
            } else {
                $product->discountOnPremium = null;
            }

            if (!$product->isLic) {
                $product->premiumBeforeCharge = $product->premiumAmount;

                $product->mopAmount = ($product->mop / $settings['hundreds']) * $product->premiumBeforeCharge;
                $product->premiumAmount = $product->premiumBeforeCharge + $product->mopAmount;
            }
            // premium calculation ends here

            $product->features = $this->calculateFeatures($product, $age, $term, $data, $settings);

            if (count($product->features) > 0) {
                $product->benefit = $product->features->sum('amount');
            } else {
                $product->benefit = 0;
            }

            $product->premiumAmountWithBenefit = $product->premiumAmount + $product->benefit;
            // benefit calculation ends here

            $product->totalPremiumAmount = $product->premiumAmountWithBenefit;

            // bonus calculation starts here
            $bonus = BonusRateEP::select('term_rate as rate')
                ->where('first_year', '<=', $term->term)
                ->where('second_year', '>=', $term->term)
                ->whereProductId($product->id)
                ->first();

            if ($bonus) {
                $bonus->yearly = (int)$sum * $bonus->rate;
                $bonus->endOfPeriod = $bonus->yearly * (int)$term->term;
                $bonus->total = $bonus->endOfPeriod + (int)$sum;
            } else {
                $bonus = collect();
                $bonus->rate = 0;
                $bonus->yearly = 0;
                $bonus->endOfPeriod = 0;
                $bonus->total = 0;
            }

            $product->bonusYearly = $bonus->yearly;
            $product->bonus = $bonus->endOfPeriod;

            $product->totalPremiumAmount = $bonus->total;

            unset($bonus);
            // bonus calculation ends here

            // net gain calculation starts here
            $product->actualPremium = $product->premiumAmountWithBenefit * $term->term;
            $product->netGain = $product->totalPremiumAmount - $product->actualPremium;
            // net gain calculation ends here

//            if ($data['selectedCategory'] == 'money-back' || $data['selectedCategory'] == 'dhan-bristi') {
            $product->paybackSchedules = $this->calculatePaybackSchedule($product, $sum);
//            } else {
//                $product->paybackSchedules = null;
//            }

            $paying_term = $product->paying_term()->where('term_id', $term->id)->first();
            if ($paying_term) {
                $product->paying_year = $paying_term->paying_year;
            } else {
                $product->paying_year = null;
            }
//            dd($product);
        }

        return $products;
    }

    private function calculateFeatures($product, $age, $term, $data, $settings)
    {
        $features = $data['features'];
        if ($features && count($features)) {
            $termId = $term->id;
            $ageId = $age->id;
            foreach ($features as $featureCode) {

                if ($data['selectedCategory'] == 'children' || $data['selectedCategory'] == 'education') {
                    if ($product->isLic) {
                        $termId = Term::where('term', $data['actualTerm'])->first()->id;
                    }
                    $ageId = Policy_age::where('age', $data['selectedProposersAge'])->first()->id;
                }

                $featureRow = Feature::whereCode($featureCode)->first();

                $productFeature = ProductFeature::whereProductId($product->id)
                    ->whereFeatureId($featureRow->id)
                    ->first();

                if ($productFeature) {
                    $featureRateRow = ProductFeatureRates::whereAgeId($ageId)
                        ->whereTermId($termId)
                        ->whereProductFeatureId(
                            $productFeature->id
                        )
                        ->first();

                    $data[$featureCode . 'Rate'] = $featureRateRow ? $featureRateRow->rate : 0;

                    if ($featureCode == 'pwb' && ($data['selectedCategory'] == 'children' || $data['selectedCategory'] == 'education')) {
                        $data[$featureCode . 'Amount'] = $data[$featureCode . 'Rate'] / $settings['hundreds'] * $product->premiumAmount;
                    } elseif ($featureCode == 'term_rider') {
                        if ($product->isNational && $data['selectedSumAssured'] > $settings['term_rider_national']) {
                            $data[$featureCode . 'Amount'] = $data[$featureCode . 'Rate'] / $settings['thousands'] * $settings['term_rider_national'];
                        } elseif ($product->isLic && $data['selectedSumAssured'] > $settings['term_rider']) {
                            $data[$featureCode . 'Amount'] = $data[$featureCode . 'Rate'] / $settings['thousands'] * $settings['term_rider'];
                        } else {
                            $data[$featureCode . 'Amount'] = $data[$featureCode . 'Rate'] / $settings['thousands'] * $data['selectedSumAssured'];
                        }
                    } else {
                        $data[$featureCode . 'Amount'] = $data[$featureCode . 'Rate'] / $settings['thousands'] * $data['selectedSumAssured'];
                    }
                }
            }
        }

        $featureArr = [];

        if (array_key_exists('adbRate', $data) && array_key_exists('ptd_pwbRate', $data)) {
            $data['adbPwbPtdRate'] = $data['adbRate'] + $data['ptd_pwbRate'];
            $data['adbPwbPtdAmount'] = $data['adbAmount'] + $data['ptd_pwbAmount'];

            $featureArr[] = [
                'code' => 'adb_pwb_ptd',
                'rate' => $data['adbPwbPtdRate'],
                'amount' => $data['adbPwbPtdAmount'],
            ];

            unset($data['adbRate']);
            unset($data['adbAmount']);
            unset($data['ptd_pwbRate']);
            unset($data['ptd_pwbAmount']);

            unset($data['features'][array_search('adb', $data['features'])]);
            unset($data['features'][array_search('ptd_pwb', $data['features'])]);
        }

        if (array_key_exists('husband_adbRate', $data) && array_key_exists('wife_adbRate', $data)) {
            $data['couple_adbRate'] = $data['husband_adbRate'] + $data['wife_adbRate'];
            $data['couple_adbAmount'] = $data['husband_adbAmount'] + $data['wife_adbAmount'];

            $featureArr[] = [
                'code' => 'couple',
                'rate' => $data['couple_adbRate'],
                'amount' => $data['couple_adbAmount'],
            ];

//            dd($data['couple_adbAmount']);
            unset($data['husband_adbRate']);
            unset($data['husband_adbAmount']);
            unset($data['wife_adbRate']);
            unset($data['wife_adbAmount']);

            unset($data['features'][array_search('husband_adb', $data['features'])]);
            unset($data['features'][array_search('wife_adb', $data['features'])]);
        }

        if ($features && count($features)) {
            foreach ($features as $code) {
                if (array_key_exists($code . 'Rate', $data)) {
                    $featureArr[] = [
                        'code' => $code,
                        'rate' => $data[$code . 'Rate'],
                        'amount' => $data[$code . 'Amount'],
                    ];
                }
            }
        }

        return collect($featureArr);
    }

    private function calculatePaybackSchedule($product, $sum)
    {
        // Payback schedule with amount
        $paybackSchedule = PaybackSchedule::whereTermYear($product->currentTerm)
            ->whereProductId($product->id)
            ->select('payback_year', 'rate')
            ->get();

        foreach ($paybackSchedule as $payback) {
            $payback->amount = $sum * ($payback->rate / 100);
        }

        return $paybackSchedule;
    }

    public function generatePdf()
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml('hello world');
        return $dompdf->download('compare.pdf');
    }
}
