<?php

namespace App\Http\Controllers;

use App;
use Response;
use Exception;
use App\Models\Team;
use App\Models\Term;
use App\Models\User;
use App\Models\WhyUs;
use App\Models\Values;
use App\Models\AboutWe;
use App\Models\Company;
use App\Models\Feature;
use App\Models\Product;
use App\Models\Policy_age;
use App\Models\SumAssured;
use App\Models\Association;
use App\Models\BonusRateEP;
use App\Models\Testimonial;
use App\Models\WhyDifferent;
use Illuminate\Http\Request;
use App\Models\LoadingCharge;
use App\Models\ContactMessage;
use App\Models\GeneralSetting;
use App\Models\ProductFeature;
use App\Models\Rate_endowment;
use App\Models\ProductFeatureRates;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon; // Include Class in COntroller

class FrontendController extends Controller
{
    public function home()
    {
//        session()->flush();
        $data['whyUs'] = WhyUs::orderBy('created_at', 'desc')->where('is_definition',0)->get();
        $data['whyUsContent'] = WhyUs::where('is_definition',1)->first();
        $data['whyDifferent'] = WhyDifferent::orderBy('created_at', 'desc')->where('is_definition',0)->get();
        $data['whyDifferentContent'] = WhyDifferent::where('is_definition',1)->first();
        $data['testimonials'] = Testimonial::orderBy('created_at', 'desc')->where('status',1)->get();
        $data['averageStars'] = Testimonial::avg('rating');
        $data['totalUsers'] = User::count();
        $data['associations'] = Association::orderBy('created_at', 'desc')->get();
//        return $data;
        return view('frontend.homePage', $data);
    }

    public function contact()
    {

        return view('frontend.contact');
    }
    public function contactStore(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:10',
//            'message' => 'required|min:10'
        ]);

        $data = new ContactMessage();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->message = $request->message ?? 'N/A';
        $data->save();
        Session::flash('message', 'Message sent successfully.');
        return back();
    }

    public function about()
    {
        $data['aboutUs'] = AboutWe::orderBy('created_at', 'desc')->where('is_definition',0)->get();
        $data['aboutUsContent'] = AboutWe::where('is_definition',1)->first();
        $data['values'] = Values::orderBy('created_at', 'desc')->where('is_definition',0)->get();
        $data['valuesContent'] = Values::where('is_definition',1)->first();
        $data['teams'] = Team::orderBy('created_at', 'desc')->where('status',1)->get();
         return view('frontend.about-page',$data);
    }

    public function calculatorScreen(Request $request){


        $data['categories'] = Product::get()->unique('category')->pluck('category');

        $data['mops'] = GeneralSetting::where('type', 'mop')->pluck('value');

         return view('frontend.calculator-screen',$data);

    }

    public function compareScreen(Request $request){
        //  dd($request->all());

     // To check result

        $data['categories'] = Product::get()->unique('category')->pluck('category');
        $data['companies'] = Company::orderBy('created_at', 'desc')->get();
        $data['selectedCategory'] = $request->category;
        $data['selectedChildAge'] = $request->child_age;
      //  $data['selectedAge'] = Carbon::parse($date_of_birth)->diff(Carbon::now())->y;
      $data['selectedAge']= $request->age;
      $data['selectedTerm'] = 0;
      if($request->term > 0){
        $data['selectedTerm'] = $request->term;
      }
      if($request->term1 > 0){
        $data['selectedTerm'] = $request->term1;
      }



        $data['selectedSumAssured'] = $request->sum_assured;
        $data['mops'] = GeneralSetting::where('type', 'mop')->pluck('value');

        $data['selectedMop'] = $request->mop;
        $data['age'] = Policy_age::whereAge($data['selectedAge'])->first();
        $data['term'] = Term::whereTerm($data['selectedTerm'])->first();

        if ($data['selectedCategory'] == 'children') {
            $data['actualTerm'] = $data['selectedTerm'] - $data['selectedChildAge'];
        } elseif ($data['selectedCategory'] == 'education') {
            $data['actualTerm'] = $data['selectedTerm'];
        } else {
            $data['actualTerm'] = $data['selectedTerm'];
        }

        $data['isChildPlan'] = $data['selectedCategory'] === 'children' || $data['selectedCategory'] === 'education';

        $data['features'] = Feature::all();

        $data['selectedfeatures']=[];
        if(isset($request->features)){
            $data['selectedfeatures'] = $request->features;
        }

        $data['companies'] = [];
        if($request->company_id){
            $data['companies'] = $request->company_id;
        }

        $data['terms'] = Term::orderBy('term')
            ->where('term', '>', 0)
            ->get('term')
            ->unique('term')
            ->pluck('term');

        // return $data;
        $data['requestedData'] = $request ? $request->all() : '';
        $data['products'] = $this->compareProducts(
            $data['selectedCategory'],
            $data['age'],
            $data['term'],
            $data['selectedMop'],
            $data['selectedSumAssured'],
            $data['requestedData'],
            $data['selectedfeatures'],
            $data['companies'],
        );

       if($request->is_ajax && $request->is_ajax == 1){
        //    return ('hello');
        // return $request;
        return view('frontend.Partials.compareResult',$data);
       }

        return view('frontend.compare',$data);


}


        private function compareProducts($category, $age, $term, $mop, $sum,$requestedData,$selectedfeatures,$companies)
    {

        $settings = GeneralSetting::whereType('calculation')->get()->pluck('value', 'key');

        $products = Product::whereType('life')
            ->whereCategory($category)
            ->whereIsActive(true)
            ->select('id', 'name', 'company_id')
            ->get();
            // dd($companies);
            if($companies){
                $products = Product::whereType('life')
                ->whereIn('company_id',$companies)
                ->whereCategory($category)
                ->whereIsActive(true)
                ->select('id', 'name', 'company_id')
                ->get();
            }
            // dd($products);


        foreach($products as $key => $product) {

            $product->isLic = $product->company->code == 'LIC';

            // table rates

            $tableRate = Rate_endowment::whereAgeId($age->id)
                ->whereTermId($term->id)
                ->whereProductId($product->id)
                ->first();

            if ($tableRate) {
                $product->rate = $tableRate->rate;
            } else {
                unset($products[$key]);
            }
            
            unset($tableRate);


            // loading charges
            $loadingCharge = LoadingCharge::whereProductId($product->id)
                ->first();

            if ($loadingCharge) {
                $product->mop = $loadingCharge[$mop];
            }
            unset($loadingCharge);

            if ($product->isLic) {
                $product->mopRate = $product->mop ? $product->rate * $product->mop : $product->rate;
            }

            // discount on sa
            $discountOnSA = SumAssured::where('first_amount', '<=', $sum)
                ->where('second_amount', '>=', $sum)
                ->whereProductId($product->id)
                ->first();

            $product->discountRate = $discountOnSA ? $discountOnSA->discount_value : 0;
            unset($discountOnSA);

            // new rate
            $product->newRate = ($product->isLic ? $product->mopRate : $product->rate) - $product->discountRate;

            // premium amount
            $product->premiumAmount = ($product->newRate / $settings['thousands']) * $sum;

            if (!$product->isLic) {
                $product->premiumBeforeCharge = $product->premiumAmount;

                $product->mopAmount = ($product->mop / $settings['hundreds']) * $product->premiumBeforeCharge;
//                dd($product->mopAmount);
                $product->premiumAmount = $product->premiumBeforeCharge + $product->mopAmount;
//                dd($product->premiumAmount);
            }

            $product->totalPremiumAmount = $product->premiumAmount;

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
                $bonus->rate = 'N/A';
                $bonus->yearly = 'N/A';
                $bonus->endOfPeriod = 'N/A';
                $bonus->total = 'N/A';
            }

            $product->bonus = $bonus->endOfPeriod;


            if ($product->bouns !== 'N/A') {
                $product->return = (int)$bonus->total;
            }
            unset($bonus);

            $featureIds = ProductFeature::where('product_id', $product->id)->pluck('feature_id');
            $product->features = Feature::whereIn('id', $featureIds)->get();



          //     if(isset($requestedData)){
            //       dd($requestedData);
            if(isset($selectedfeatures)){
            foreach($selectedfeatures as $featureCode){
               // benefit calculation starts here ADB or PWB
            $featureRow = Feature::whereCode($featureCode)->first();

            if ($featureCode == 'pwb') {
                if ($product->isLic) {
                    $term = Term::where('term', $data['actualTerm'])->first();
                }
                $age = Policy_age::where('age', $data['selectedProposersAge'])->first();
            }

            $productFeature = ProductFeature::whereProductId($product->id)
                ->whereFeatureId($featureRow->id)
                ->first();

            if ($productFeature) {
                $featureRateRow = ProductFeatureRates::whereAgeId($age->id)
                    ->whereTermId($term->id)
                    ->whereProductFeatureId(
                        $productFeature->id
                    )
                    ->first();
            } else {
                $featureRateRow = null;
            }

            $benefitRate = $featureRateRow ? $featureRateRow->rate : 0;

            if ($category === 'children' || $category === 'education') {
                $product->benefit = $benefitRate / $settings['hundreds'] * $product->premiumAmount;
            } else {
                $product->benefit = $benefitRate / $settings['thousands'] * $sum;
            }



          $product->premiumAmount += $product->benefit;
            // benefit calculation ends here

            $product->totalPremiumAmount = $product->premiumAmount;
                   $pafterbenefits =$product->totalPremiumAmount;
            }
        }


}

        return $products;

    }


    public function confirmation(Request $request){


       $selectedfeatures =$request->features;


        $product = Product::find($request->product);


        $category = $product->category;

        $featureIds = ProductFeature::where('product_id', $product->id)->pluck('feature_id');
        $product->features = Feature::whereIn('id', $featureIds)->get();
        $prof =  $product->features;
        $mopsall = GeneralSetting::where('type', 'mop')->pluck('value');

        $settings = GeneralSetting::whereType('calculation')->get()->pluck('value', 'key');
        $age = Policy_age::whereAge($request->age)->first();
        $term = Term::whereTerm($request->term)->first();
    $mop=$request->mop;
    $sum=$request->sum;
        $product->isLic = $product->company->code == 'LIC';

        // table rates

        $tableRate = Rate_endowment::whereAgeId($age->id)
            ->whereTermId($term->id)
            ->whereProductId($product->id)
            ->first();


        if ($tableRate) {
            $product->rate = $tableRate->rate;
        } else {
            unset($products[$key]);
        }
        unset($tableRate);

        // loading charges
        $loadingCharge = LoadingCharge::whereProductId($product->id)
            ->first();

        if ($loadingCharge) {
            $product->mop = $loadingCharge[$mop];
        }


        if ($product->isLic) {
            $product->mopRate = $product->mop ? $product->rate * $product->mop : $product->rate;
        }

        // discount on sa
        $discountOnSA = SumAssured::where('first_amount', '<=', $sum)
            ->where('second_amount', '>=', $sum)
            ->whereProductId($product->id)
            ->first();

        $product->discountRate = $discountOnSA ? $discountOnSA->discount_value : 0;
        unset($discountOnSA);

        // new rate
        $product->newRate = ($product->isLic ? $product->mopRate : $product->rate) - $product->discountRate;

        // premium amount
        $product->premiumAmount = ($product->newRate / $settings['thousands']) * $sum;

        if (!$product->isLic) {
            $product->premiumBeforeCharge = $product->premiumAmount;

            $product->mopAmount = ($product->mop / $settings['hundreds']) * $product->premiumBeforeCharge;
//                dd($product->mopAmount);
            $product->premiumAmount = $product->premiumBeforeCharge + $product->mopAmount;
//                dd($product->premiumAmount);
        }

        $product->totalPremiumAmount = (int) $product->premiumAmount;

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
            $bonus->rate = 'N/A';
            $bonus->yearly = 'N/A';
            $bonus->endOfPeriod = 'N/A';
            $bonus->total = 'N/A';
        }

        $product->bonus = $bonus->endOfPeriod;


        if ($product->bouns !== 'N/A') {
            $product->return =$bonus->total;
        }
        unset($bonus);

        $featureIds = ProductFeature::where('product_id', $product->id)->pluck('feature_id');
        $product->features = Feature::whereIn('id', $featureIds)->get();


        foreach($selectedfeatures  as $featureCode){
            // benefit calculation starts here ADB or PWB



         $featureRow = Feature::whereCode(json_decode($featureCode))->first();

         if ($featureCode == 'pwb') {
             if ($product->isLic) {
                 $term = Term::where('term', $data['actualTerm'])->first();
             }
             $age = Policy_age::where('age', $data['selectedProposersAge'])->first();
         }

         $productFeature = ProductFeature::whereProductId($product->id)
             ->whereFeatureId($featureRow->id)
             ->first();

         if ($productFeature) {
             $featureRateRow = ProductFeatureRates::whereAgeId($age->id)
                 ->whereTermId($term->id)
                 ->whereProductFeatureId(
                     $productFeature->id
                 )
                 ->first();
         } else {
             $featureRateRow = null;
         }

         $benefitRate = $featureRateRow ? $featureRateRow->rate : 0;

         if ($category === 'children' || $category === 'education') {
             $product->benefit = $benefitRate / $settings['hundreds'] * $product->premiumAmount;
         } else {
             $product->benefit = $benefitRate / $settings['thousands'] * $sum;
         }



       $product->premiumAmount += $product->benefit;
         // benefit calculation ends here

         $product->totalPremiumAmount = $product->premiumAmount;
                $pafterbenefits =$product->totalPremiumAmount;
         }


        $reqterm = $term->term;
        return view('frontend.confirmation')->with('age',$request->age)
        ->with('term',$request->term)
        ->with('sum',$request->sum)
        ->with('mop',$request->mop)
        ->with('mopc',$mopsall)
        ->with('product',$product)
        ->with('profeatures',$request->features);
    }


    public function confirm(Request $request){



        $product = Product::find($request->product);
        $category = $product->category;

        $featureIds = ProductFeature::where('product_id', $product->id)->pluck('feature_id');
        $product->features = Feature::whereIn('id', $featureIds)->get();
        $prof =  $product->features;
        $mopsall = GeneralSetting::where('type', 'mop')->pluck('value');

        $settings = GeneralSetting::whereType('calculation')->get()->pluck('value', 'key');
        $age = Policy_age::whereAge($age)->first();
        $term = Term::whereTerm($term)->first();

        $product->isLic = $product->company->code == 'LIC';

        // table rates

        $tableRate = Rate_endowment::whereAgeId($age->id)
            ->whereTermId($term->id)
            ->whereProductId($product->id)
            ->first();

        if ($tableRate) {
            $product->rate = $tableRate->rate;
        } else {
            unset($products[$key]);
        }
        unset($tableRate);

        // loading charges
        $loadingCharge = LoadingCharge::whereProductId($product->id)
            ->first();

        if ($loadingCharge) {
            $product->mop = $loadingCharge[$mop];
        }


        if ($product->isLic) {
            $product->mopRate = $product->mop ? $product->rate * $product->mop : $product->rate;
        }

        // discount on sa
        $discountOnSA = SumAssured::where('first_amount', '<=', $sum)
            ->where('second_amount', '>=', $sum)
            ->whereProductId($product->id)
            ->first();

        $product->discountRate = $discountOnSA ? $discountOnSA->discount_value : 0;
        unset($discountOnSA);

        // new rate
        $product->newRate = ($product->isLic ? $product->mopRate : $product->rate) - $product->discountRate;

        // premium amount
        $product->premiumAmount = ($product->newRate / $settings['thousands']) * $sum;

        if (!$product->isLic) {
            $product->premiumBeforeCharge = $product->premiumAmount;

            $product->mopAmount = ($product->mop / $settings['hundreds']) * $product->premiumBeforeCharge;
//                dd($product->mopAmount);
            $product->premiumAmount = $product->premiumBeforeCharge + $product->mopAmount;
//                dd($product->premiumAmount);
        }

        $product->totalPremiumAmount = (int) $product->premiumAmount;

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
            $bonus->rate = 'N/A';
            $bonus->yearly = 'N/A';
            $bonus->endOfPeriod = 'N/A';
            $bonus->total = 'N/A';
        }

        $product->bonus = $bonus->endOfPeriod;


        if ($product->bouns !== 'N/A') {
            $product->return =$bonus->total;
        }
        unset($bonus);

        $featureIds = ProductFeature::where('product_id', $product->id)->pluck('feature_id');
        $product->features = Feature::whereIn('id', $featureIds)->get();


        foreach($product->features  as $feature){
            // benefit calculation starts here ADB or PWB

        $feature = Feature::find($feature->id);
      $featureCode = $feature->code;
         $featureRow = Feature::whereCode($featureCode)->first();

         if ($featureCode == 'pwb') {
             if ($product->isLic) {
                 $term = Term::where('term', $data['actualTerm'])->first();
             }
             $age = Policy_age::where('age', $data['selectedProposersAge'])->first();
         }

         $productFeature = ProductFeature::whereProductId($product->id)
             ->whereFeatureId($featureRow->id)
             ->first();

         if ($productFeature) {
             $featureRateRow = ProductFeatureRates::whereAgeId($age->id)
                 ->whereTermId($term->id)
                 ->whereProductFeatureId(
                     $productFeature->id
                 )
                 ->first();
         } else {
             $featureRateRow = null;
         }

         $benefitRate = $featureRateRow ? $featureRateRow->rate : 0;

         if ($category === 'children' || $category === 'education') {
             $product->benefit = $benefitRate / $settings['hundreds'] * $product->premiumAmount;
         } else {
             $product->benefit = $benefitRate / $settings['thousands'] * $sum;
         }



       $product->premiumAmount += $product->benefit;
         // benefit calculation ends here

         $product->totalPremiumAmount = $product->premiumAmount;
                $pafterbenefits =$product->totalPremiumAmount;
         }


        $reqterm = $term->term;
        return view('frontend.confirmation')->with('age',$request->age)
        ->with('term',$request->term)
        ->with('sum',$request->sum)
        ->with('mop',$request->mop)
        ->with('mopc',$mopsall)
        ->with('product',$request->product)
        ->with('profeature',$request->features);
    }


    public function findcatFeature(Request $request)
    {
        $products = Product::where('category', $request->id)->pluck('id');
        $featureIds = ProductFeature::whereIn('product_id', $products->toArray())->pluck('feature_id');
        $data = Feature::whereIn('id', $featureIds)->get();

        return response()->json(array('success' => true, 'data' => $data));
        // return Response()::json(array('success' => true, 'data' => $data));
    }

}
