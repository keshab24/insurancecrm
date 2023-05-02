<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Models\Company;
use App\Models\CrcRate;
use App\Models\Premium;
use App\Models\Product;
use App\Models\Pwb_rate;
use App\Models\WholeAdb;
use App\Models\Policy_age;
use App\Models\SumAssured;
use App\Models\Term_rider;
use App\Models\BonusRateEP;
use Illuminate\Http\Request;
use App\Models\LoadingCharge;
use App\Models\Rate_endowment;

class PremiumController extends Controller
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
    public function create(Request $request)
    {
        $products = Product::where('category', 'endowment')->get();

        if (in_array('all', AgentCat())) {
            $companies = Company::orderBy('created_at', 'asc')->get();
        } else {
            $companies = Company::whereIn('id', AgentCategories())->get();
        }
//        dd($companies);
        return view('premiumcal.create', compact(['products', 'companies']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([

            'age' => ['required', 'numeric'],
            'term' => ['required', 'numeric'],
            'sum_assured' => ['required'],
        ]);

        $products = Product::where('company_id', $request->company_id)->get();


        if (in_array('all', AgentCat())) {
            $companies = Company::orderBy('created_at', 'asc')->get();
        } else {
            $companies = Company::whereIn('id', AgentCategories())->get();
        }

        $policyagerate = Policy_age::where('age', '=', $request->age)->first();
        $term = Term::where('term', '=', $request->term)->first();

        $rate = Rate_endowment::where('age_id', '=', $policyagerate->id)->where('term_id', '=', $term->id)->where('company_id', $request->company_id)
            ->where('product_id', $request->product_id)->first();

        //$discount = SumAssured::where('first_amount', '=',25000)->first();

        $discount = SumAssured::where('first_amount', '<=', $request->sum_assured)->where('second_amount', '>=', $request->sum_assured)->where('product_id', $request->product_id)->first();

        $bonus = BonusRateEP::where('first_year', '<=', $request->term)->where('second_year', '>=', $request->term)->where('product_id', $request->product_id)->first();
        $charge = LoadingCharge::value($request->loading_charge);
        $data['adb'] = $request->has('adb') ? 'yes' : 'no';
        $data['term_rider'] = $request->has('termrider') ? 'yes' : 'no';
     $sum_assured = $request->sum_assured;       

        if ($data['adb'] == 'yes') {
            $data['adb_rate'] = WholeAdb::where('company_id', '=', $request->company_id)
                ->where('product_id', '=', $request->product_id)
                ->first();

            $data['adb_rate'] = $data['adb_rate'] ? $data['adb_rate']->rate : 0;
        } else {
            $data['adb_rate'] = 0;
        }
        /*  $age = $request->input('age');
          $term = $request->input('term');
          $sum_assured = $request->input('sum_assured');
          $rate = 106.25;

          $premium = ($rate/1000)*$sum_assured;*/
if(($data['adb'] == 'yes')){
          $aDB =  (1/1000)*$sum_assured;
}
else{
    $aDB = 0;
}
$adbreq = $data['adb'];




if(($data['term_rider'] == 'yes')){
    $term_rider_rate = Term_rider::where('age_id', '=', $policyagerate->id)->where('term_id', '=', $term->id)->where('company_id', $request->company_id)
->where('product_id', $request->product_id)->first()->rate;
$term_rider = $term_rider_rate/1000*400000;
}
else{
    $term_rider = 0;
    $term_rider_rate = 0;
}
$term_riderreq = $data['term_rider'];
      

            

        $product = Product::where('id', $request->product_id)->first();
        $company = Company::where('id', $request->company_id)->first();


        return view('premiumcal.result')->with('age', request('age'))
            ->with('term', request('term'))
            ->with('rate', $rate)
            ->with('loading_charge', request('loading_charge'))
            ->with('discount', $discount)
            ->with('bonus', $bonus)
            ->with('companies', $companies)
            ->with('company', $company)
            ->with('aDB', $aDB)
            ->with('adbreq', $adbreq)

            ->with('term_rider', $term_rider)
            ->with('term_riderreq', $term_riderreq)


            ->with('product', $product)
            ->with('products', $products)
            ->with('term_rider_rate', $term_rider_rate)
            ->with('charge', $charge)
            ->with('sum_assured', request('sum_assured'));


    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Premium $premium
     * @return \Illuminate\Http\Response
     */
    public function show(Premium $premium)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Premium $premium
     * @return \Illuminate\Http\Response
     */
    public function edit(Premium $premium)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Premium $premium
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Premium $premium)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Premium $premium
     * @return \Illuminate\Http\Response
     */
    public function childvidya()
    {

        $companies = Company::orderBy('created_at', 'asc')->get();
        return view('premiumcal.child_jeevan_vidya')->with('companies', $companies);
    }

    public function childjeevanvidya(Request $request)
    {
        $validatedData = $request->validate([

            'age' => ['required', 'numeric'],
            'term' => ['required', 'numeric'],
            'sum_assured' => ['required'],
        ]);

        // $product = Product::where('id', $request->product_id)->first();
        $company = Company::where('id', $request->company_id)->first();
        $product = Product::where('id', $request->product_id)->first();

        $companies = Company::orderBy('created_at', 'asc')->get();
        $policyagerate = Policy_age::where('age', '=', $request->age)->first();
        $term = Term::where('term', '=', $request->term)->first();
        $maturity = Term::where('term', '=', $request->term)->first();

        $proposerage = Policy_age::where('age', $request->proposer_age)->first();

      $pwbrate = 0;
       if ($maturity->term <= 20) {
                $pwbrate = Pwb_rate::where('age_id', '=', $proposerage->id)->where('term_id', $maturity->id)->where('company_id', $request->company_id)->first()->rate;

                //->where('product_id', $request->product_id)->first()->rate;
            }
            
    
        $rate = Rate_endowment::where('age_id', '=', $policyagerate->id)->where('company_id', $request->company_id)
            ->where('product_id', $request->product_id)->first();

        //$discount = SumAssured::where('first_amount', '=',25000)->first();


            $discount = SumAssured::where('first_amount', '<=', $request->sum_assured)->where('second_amount', '>=', $request->sum_assured)->where('company_id',$company->id)->where('product_id',$product->id)->first();


            $bonus = BonusRateEP::where('first_year', '<=', $request->term)->where('second_year', '>=', $request->term)->where('company_id',$company->id)->where('product_id',$product->id)->first();
      
        $charge = LoadingCharge::where('company_id',$company->id)->where('product_id',$product->id)->value($request->loading_charge);

        

        return view('premiumcal.jeevan_vidya')->with('age',request('age'))
        ->with('proposer_age',request('proposer_age'))
        ->with('term',request('term'))
        ->with('rate',$rate)
        ->with('companies',$companies)
        ->with('company',$company)
        ->with('product',$product)

        ->with('loading_charge',request('loading_charge'))
        ->with('discount',$discount)
        ->with('bonus',$bonus)
        ->with('pwbrate',$pwbrate)
        ->with('charge',$charge)
       ->with('sum_assured',request('sum_assured'));
         }

    public function child()
    {

        $companies = Company::orderBy('created_at', 'asc')->get();
        return view('premiumcal.child_create')->with('companies', $companies);
    }

    public function childpost(Request $request)
    {
        $customMessages = [
            'mod5' => 'The sum assured should be multiple of 5'
        ];

        $validatedData = $request->validate([

            'age' => ['required', 'numeric'],
            'term' => ['required', 'numeric'],
            'sum_assured' => ['required','mod5'],
        ],$customMessages);

        $products = Product::where('company_id', $request->company_id)->get();
        $product = Product::where('id', $request->product_id)->first();
        $company = Company::where('id', $request->company_id)->first();
        $companies = Company::orderBy('created_at', 'asc')->get();
        $policyagerate = Policy_age::where('age', '=', $request->age)->first();

        $proposerage = Policy_age::where('age', $request->proposer_age)->first();
        $maturity = Term::where('term', $request->term)->first();
        $pwbreq = $request->has('pwb') ? 'yes' : 'no';
        $crcreq = $request->has('crc') ? 'yes' : 'no';

        

        $pwbrate = 0;

        $term = Term::where('term', '=', $request->term)->first();
        $termlic = Term::where('term', '=', ($request->term + $request->age))->first();
        if ($request->company_id == 4 && $pwbreq == 'yes' ) {
            $term = Term::where('term', '=', ($request->term + $request->age))->first();

            $pwbrate = 0;

            if ($maturity->term <= 20) {
                $pwbrate = Pwb_rate::where('age_id', '=', $proposerage->id)->where('term_id', $maturity->id)->where('company_id', $request->company_id)->first()->rate;

                //->where('product_id', $request->product_id)->first()->rate;
            }
        } elseif ($request->company_id == 7 && $pwbreq == 'yes' ) {
            $term = Term::where('term', '=', $request->term)->first();

            $pwbrate = 0;
            $pwbrate = Pwb_rate::where('age_id', '=', $proposerage->id)->where('term_id', $maturity->id)->where('company_id', $request->company_id)->first()->rate;
        }
if($request->company_id == 4){
        $rate = Rate_endowment::where('age_id', '=', $policyagerate->id)->where('term_id', $termlic->id)->where('company_id', $request->company_id)
            ->where('product_id', $request->product_id)->first();
}else{
    $rate = Rate_endowment::where('age_id', '=', $policyagerate->id)->where('term_id', $term->id)->where('company_id', $request->company_id)
            ->where('product_id', $request->product_id)->first();
}

           

        //$discount = SumAssured::where('first_amount', '=',25000)->first();

        $discount = SumAssured::where('first_amount', '<=', $request->sum_assured)->where('second_amount', '>=', $request->sum_assured)->where('company_id', $company->id)->where('product_id', $product->id)->first();


        $bonus = BonusRateEP::where('first_year', '<=', $request->term)->where('second_year', '>=', $request->term)->where('company_id',$company->id)->where('product_id',$product->id)->first();

        $charge = LoadingCharge::where('company_id',$company->id)->where('product_id',$product->id)->value($request->loading_charge);


        if($request->company_id == 7 && $crcreq == 'yes'){
        $crcrate = CrcRate::where('age_id','=',$request->age)->where('company_id',$company->id)->where('product_id',$product->id)->first()->one_time_charge;
        }
        else{ $crcrate = null;
        }
    
        /*  $age = $request->input('age');
          $term = $request->input('term');
          $sum_assured = $request->input('sum_assured');
          $rate = 106.25;

          $premium = ($rate/1000)*$sum_assured;*/

        return view('premiumcal.child_result')->with('age', request('age'))
            ->with('proposer_age', request('proposer_age'))
            ->with('term', request('term'))
            ->with('rate', $rate)
            ->with('company', $company)
            ->with('companies', $companies)
            ->with('product', $product)
            ->with('products', $products)
            ->with('loading_charge', request('loading_charge'))
            ->with('discount', $discount)
            ->with('bonus', $bonus)
            ->with('crcrate', $crcrate)
            ->with('pwbrate', $pwbrate)
            ->with('pwbreq', $pwbreq)
            ->with('crcreq', $crcreq)


            ->with('charge', $charge)
            ->with('sum_assured', request('sum_assured'));
 

    }


    


}
