<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Term;
use App\Models\Company;
use App\Models\Premium;
use App\Models\Product;
use App\Models\Pwb_rate;
use App\Models\Policy_age;
use App\Models\SumAssured;
use App\Models\Term_rider;
use App\Models\BonusRateEP;
use App\Models\LoadingCharge;
use App\Models\Rate_endowment;

class PremiumController extends Controller
{
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

        $discount = SumAssured::where('first_amount', '<=', $request->sum_assured)->where('second_amount', '>=', $request->sum_assured)->where('product_id', $request->product_id)->first()->discount_value;

        if(isset($bonus->term_rate)){
        $bonus = BonusRateEP::where('first_year', '<=', $request->term)->where('second_year', '>=', $request->term)->where('company_id', $request->company_id)->where('product_id', $request->product_id)->first()->term_rate;
        }
       else{
      $bonus = 0.008;
       }
       $bpyear = $bonus * $sum_assured;
       $bpendyear =  $bonus * $sum_assured *10;
       $totalbonus = $bonus * $sum_assured *10 + $sum_assured;
        $charge = LoadingCharge::value($request->loading_charge);
      

      /*  $age = $request->input('age');
        $term = $request->input('term');
        $sum_assured = $request->input('sum_assured');
        $rate = 106.25;

        $premium = ($rate/1000)*$sum_assured;*/
        $term_rider_rate = Term_rider::where('age_id','=',$policyagerate->id)->where('term_id','=',$term->id)->where('company_id', $request->company_id)
        ->where('product_id', $request->product_id)->first()->rate;

       $product = Product::where('id', $request->product_id)->first();
       $company = Company::where('id', $request->company_id)->first();
       $aDB =  (1/1000)*$sum_assured;
       $accBenefit = (1/1000)*$sum_assured;
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

      $accBenefit = (1/1000)*$sum_assured;
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */  
}
 public function child(Request $request){
    $product = Product::where('id', $request->product_id)->first();
    $company = Company::where('id', $request->company_id)->first();
    $companies = Company::orderBy('created_at','asc')->get();
    $policyagerate = Policy_age::where('age','=',$request->age)->first();
    $sum_assured = $request->sum_assured;

    $proposerage = Policy_age::where('age',$request->proposer_age)->first();
    $maturity = Term ::where('term',$request->term)->first();

    $term = Term::where('term','=',($request->term+$request->age))->first();

    $rate = Rate_endowment::where('age_id','=',$policyagerate->id)->where('term_id',$term->id)
    ->where('product_id', $request->product_id)->first()->rate;

    $pwbrate = 0;

    if($maturity->term <= 20){
    $pwbrate = Pwb_rate::where('age_id','=',$proposerage->id)->where('term_id',$term->id)->where('company_id', $request->company_id)
    ->where('product_id', $request->product_id)->first()->rate;
    }

    //$discount = SumAssured::where('first_amount', '=',25000)->first();

    $discount = SumAssured::where('first_amount', '<=', $request->sum_assured)->where('second_amount', '>=', $request->sum_assured)->where('company_id',$company->id)->where('product_id',$product->id)->first()->discount_value;

    $bonus = BonusRateEP::where('first_year', '<=', $request->term)->where('second_year', '>=', $request->term)->where('product_id', $request->product_id)->where('company_id', $request->company_id)->first()->term_rate;
        

    $bpyear = $bonus * $sum_assured;
    $bpendyear =  $bonus * $sum_assured *$request->term;
    $totalbonus = $bonus * $sum_assured *$request->term + $sum_assured;

    $charge = LoadingCharge::value($request->loading_charge);
     $loading_charge = $charge * $rate;

     if(isset($charge)){
        $newRate = $rate * $charge - $discount ;
        }else{
       $newRate = $rate - $discount ;
        }

        if(isset($charge)){
            $premiumAmount = ($rate * $charge - $discount)/1000*$sum_assured;
        
            }
            elseif(isset($discount)){
        $premiumAmount = ($rate - $discount)/1000*$sum_assured;
      
            }
            else{
           $premiumAmount = ($rate-2)/1000*$sum_assured;
            }

        $pwbAmount = (($pwbrate/100) * $premiumAmount);

        $totalPremium = $pwbAmount + $premiumAmount;
               
              
  /*  $age = $request->input('age');
    $term = $request->input('term');
    $sum_assured = $request->input('sum_assured');
    $rate = 106.25;

    $premium = ($rate/1000)*$sum_assured;*/
    

    return response()->json([
        "data" => [ 'age',request('age'),
    'proposer_age'=>request('proposer_age'),
    'term'=>request('term'),
    'tablerate'=>$rate,
    'loading_charge'=> $loading_charge,
     'newrate' => $newRate,
    'company'=>$company,
    'product'=>$product,
    'loading_charge'=>request('loading_charge'),
    'discount'=>$discount,
    'premiumamount' => $premiumAmount,
    'bonus'=>$bonus,
    'pwbrate'=>$pwbrate,
    'pwbAmount' => $pwbAmount,
    'totalPremium' => $totalPremium,
    'bonus_per_year' => $bpyear,
    'bonus_at_end_year'=> $bpendyear,
    'total payment at end'=>$totalbonus,
    'charge'=>$charge,
   'sum_assured'=>request('sum_assured'),
    ],
    "success" => false
], 400);

 }

 public function childjeevanvidya(Request $request){
    $product = Product::where('id', $request->product_id)->first();
    $company = Company::where('id', $request->company_id)->first();
    $companies = Company::orderBy('created_at','asc')->get();
    $policyagerate = Policy_age::where('age','=',$request->age)->first();
    $sum_assured = $request->sum_assured;

    $proposerage = Policy_age::where('age',$request->proposer_age)->first();
    $maturity = Term ::where('term',$request->term)->first();

    $term = Term::where('term','=',($request->term+$request->age))->first();

    $rate = Rate_endowment::where('age_id','=',$policyagerate->id)->where('term_id',$term->id)
    ->where('product_id', $request->product_id)->first()->rate;
  
    $pwbrate = Pwb_rate::where('age_id','=',$proposerage->id)->where('term_id',$term->id)->where('company_id', $request->company_id)
    ->where('product_id', $request->product_id)->first()->rate;
    
    //$discount = SumAssured::where('first_amount', '=',25000)->first();

    $discount=0;
    if($request->sum_assured>=0 && $request->sum_assured<=199999){
        $discounton = 0;
    }

    else{
        $discount = 1;
    }


// $discount = SumAssured::where('first_amount', '<=', $request->sum_assured)->where('second_amount', '>=', $request->sum_assured)->where('product_id',$product->id)->first();


$bonusrate=0;
if($request->term>=5 && $request->term<=15){
   $bonus = 0.066;
}
elseif($request->term>=15 && $request->term<=20){
   $bonus = 0.067;
}
else{
   $bonus = 0.068;
}

//$bonus = BonusRateEP::where('first_year', '<=', $request->term)->where('second_year', '>=', $request->term)->first();
$charge = LoadingCharge::value($request->loading_charge);



    $bpyear = $bonus * $sum_assured;
    $bpendyear =  $bonus * $sum_assured *$request->term;
    $totalbonus = $bonus * $sum_assured *$request->term + $sum_assured;

     $loading_charge = $charge * $rate;

     if(isset($charge)){
        $newRate = $rate * $charge - $discount ;
        }else{
       $newRate = $rate - $discount ;
        }

        if(isset($charge)){
            $premiumAmount = ($rate * $charge - $discount)/1000*$sum_assured;
        
            }
            elseif(isset($discount)){
        $premiumAmount = ($rate - $discount)/1000*$sum_assured;
      
            }
            else{
           $premiumAmount = ($rate-2)/1000*$sum_assured;
            }

        $pwbAmount = (($pwbrate/100) * $premiumAmount);

        $totalPremium = $pwbAmount + $premiumAmount;
               
              
  /*  $age = $request->input('age');
    $term = $request->input('term');
    $sum_assured = $request->input('sum_assured');
    $rate = 106.25;

    $premium = ($rate/1000)*$sum_assured;*/
    

    return response()->json([
        "data" => [ 'age',request('age'),
    'proposer_age'=>request('proposer_age'),
    'term'=>request('term'),
    'tablerate'=>$rate,
    'loading_charge'=> $loading_charge,
     'newrate' => $newRate,
    'company'=>$company,
    'product'=>$product,
    'loading_charge'=>request('loading_charge'),
    'discount'=>$discount,
    'premiumamount' => $premiumAmount,
    'bonus'=>$bonus,
    'pwbrate'=>$pwbrate,
    'pwbAmount' => $pwbAmount,
    'totalPremium' => $totalPremium,
    'bonus_per_year' => $bpyear,
    'bonus_at_end_year'=> $bpendyear,
    'total payment at end'=>$totalbonus,
    'charge'=>$charge,
   'sum_assured'=>request('sum_assured'),
    ],
    "success" => false
], 400);

 }
}