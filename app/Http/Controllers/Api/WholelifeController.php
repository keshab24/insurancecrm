<?php

namespace App\Http\Controllers\Api;

use App\Models\Term;
use App\Models\Company;
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
use App\Http\Controllers\Controller;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $companies = Company::orderBy('created_at','asc')->get();
        $policyagerate = Policy_age::where('age','=',$request->age)->first();
        $term = Term::where('term','=',$request->term)->first();
        $sum_assured = $request->sum_assured;
        $rate = Rate_endowment::where('age_id','=',$policyagerate->id)->where('term_id','=',$term->id)->where('company_id', $request->company_id)
        ->where('product_id', $request->product_id)->first()->rate;

        //$discount = SumAssured::where('first_amount', '=',25000)->first();

        $discount = 0;
        if ($request->sum_assured >= 0 && $request->sum_assured <= 199000) {
            $discount = 0;
        } elseif ($request->sum_assured >= 200000 && $request->sum_assured <= 299000) {
            $discount = 1;
        } else {
            $discount = 2;
        }

       $bonus = 0;
        if ($request->term >= 5 && $request->term <= 15) {
            $bonus = 0.066;
        } elseif ($request->term >= 15 && $request->term <= 20) {
            $bonus = 0.068;
        } else {
            $bonus = 0.077;
        }
       $bpyear = $bonus * $sum_assured;
       $bpendyear =  $bonus * $sum_assured * $request->term;
       $totalbonus = $bonus * $sum_assured *$request->term + $sum_assured;
        $charge = LoadingCharge::value($request->loading_charge);
      

      /*  $age = $request->input('age');
        $term = $request->input('term');
        $sum_assured = $request->input('sum_assured');
        $rate = 106.25;

        $premium = ($rate/1000)*$sum_assured;*/
        $term_rider_rate = Term_rider::where('age_id', '=', $policyagerate->id)->where('term_id', '=', $term->id)->where('company_id', $request->company_id)
        ->first()->rate;

       $product = Product::where('id', $request->product_id)->first();
       $company = Company::where('id', $request->company_id)->first();
       $aDB =  WholeAdb::where('age_id', '=', $policyagerate->id)->where('term_id', '=', $term->id)->where('company_id', $request->company_id)
       ->where('product_id', $request->product_id)->first()->rate;

       $accBenefit = ($aDB * ($request->sum_assured)) / 1000;
       $term_rider = $term_rider_rate/1000*400000;

       if(isset($charge)){
       $newRate = $rate * $charge - $discount ;
       }else{
      $newRate = $rate - $discount ;
       }
      $loading_charge = $rate * $charge;

      if(isset($charge)){
      $premiumAmount = ($rate * $charge - $discount)/1000*$sum_assured;
     
      }
      elseif(isset($discount)){
  $premiumAmount = ($rate - $discount)/1000*$sum_assured;

      }
      else{
     $premiumAmount = ($rate-2)/1000*$sum_assured;
      }

      $term_rider = $term_rider_rate/1000*400000;
      $totalPremium = $term_rider + $accBenefit +  $premiumAmount;

       return response()->json([
        "data" => [
            'rate'=> $rate,
            'aDB' => $aDB,
            'discount'=>$discount,
            'sum_assured' => $request->sum_assured,
            'term' => $request->term,
            'age' => $request->age,
            'loading_charge' => $loading_charge,
            'term_rider_rate' => $term_rider_rate,
            'charge'=>$charge,
            'newRate' => $newRate,
            'premiumAmount' => $premiumAmount,
            'accBenefit' => $accBenefit,
            'term_rider' => $term_rider,
            'totalPremium' => $totalPremium,
            'bonus_rate' => $bonus,
            'bonus_per_year' => $bpyear,
            'bonus_at_end_year' => $bpendyear,
            'total_bonus' => $totalbonus,
             
            'company' => $company,
            'product' => $product,
        ],
        "success" => false
    ], 400);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
