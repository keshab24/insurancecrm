<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use App\Models\TravelMedicalInsurance;
use Illuminate\Http\Request;

class TravelMedicalInsuranceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function TravelDatas()
    {
        $url = GeneralSetting::where('key', 'api_url')->first()->value;
        $apiUser = base64_encode(GeneralSetting::where('key', 'api_username')->first()->value . ':' . GeneralSetting::where('key', 'api_user_password')->first()->value);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/Api/TMICalculator/TMICoverType",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => '',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic ' . $apiUser,
            ),
        ));

        $data['coverTypes'] = json_decode(curl_exec($curl));

//        $datas = array(
//            "PACKAGE" => "a",
//        );
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => "https://www.nrb.org.np/api/forex/v1/rates",
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => '',
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 0,
//            CURLOPT_FOLLOWLOCATION => true,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => 'GET',
//            CURLOPT_POSTFIELDS => json_encode($datas),
//            CURLOPT_HTTPHEADER => array(
//                'Content-Type: application/json',
//            ),
//        ));
//
//        $data['rates'] = json_decode(curl_exec($curl));
        curl_close($curl);
//        dd($data);
        return $this->variable = $data;
    }

    public function getPlans(Request $request)
    {
//        return $request;
        $url = GeneralSetting::where('key', 'api_url')->first()->value;
        $apiUser = base64_encode(GeneralSetting::where('key', 'api_username')->first()->value . ':' . GeneralSetting::where('key', 'api_user_password')->first()->value);

        $curl = curl_init();
        $datas = array(
            "PACKAGE" => $request->PACKAGE,
        );
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/Api/TMICalculator/TMIPlan",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($datas),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic ' . $apiUser,
            ),
        ));

        $tmiPlans = json_decode(curl_exec($curl));
        curl_close($curl);
        if ($tmiPlans) {
            return response()->json([
                'type' => 'success',
                'tmiPlans' => $tmiPlans,
                'message' => 'Calculated successfully.'
            ], 200);
        } else {
            return response()->json([
                'type' => 'success',
                'tmiPlans' => $tmiPlans,
                'message' => 'Calculation error.'
            ], 500);
        }
    }

    public function getPackages(Request $request)
    {
//        return $request;
        $url = GeneralSetting::where('key', 'api_url')->first()->value;
        $apiUser = base64_encode(GeneralSetting::where('key', 'api_username')->first()->value . ':' . GeneralSetting::where('key', 'api_user_password')->first()->value);

        $curl = curl_init();
        $datas = array(
            "COVERTYPE" => $request->COVERTYPE,
            "PLAN" => $request->PLAN
        );
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/Api/TMICalculator/TMIPackage",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($datas),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic ' . $apiUser,
            ),
        ));

        $tmiPackages = json_decode(curl_exec($curl));
        curl_close($curl);
        if ($tmiPackages) {
            return response()->json([
                'type' => 'success',
                'tmiPackages' => $tmiPackages,
                'message' => 'Calculated successfully.'
            ], 200);
        } else {
            return response()->json([
                'type' => 'success',
                'tmiPackages' => $tmiPackages,
                'message' => 'Calculation error.'
            ], 500);
        }
    }

    public function getPremium(Request $request)
    {
//        return $request;
        $url = GeneralSetting::where('key', 'api_url')->first()->value;
        $apiUser = base64_encode(GeneralSetting::where('key', 'api_username')->first()->value . ':' . GeneralSetting::where('key', 'api_user_password')->first()->value);

        $curl = curl_init();
        $datas = array(
            "COVERTYPE" => $request->COVERTYPE,
            "PLAN" => $request->PLAN,
            "PACKAGE" => $request->PACKAGE,
            "Age" => $request->Age ?? 0,
            "Day" => $request->Day ?? 0,
            "ISANNUALTRIP" => $request->ISANNUALTRIP ?? '0'
    );
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/Api/TMICalculator/CalculateTMIPremium",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($datas),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic ' . $apiUser,
            ),
        ));

        $tmiPremium = json_decode(curl_exec($curl));
        curl_close($curl);
        if ($tmiPremium) {
            return response()->json([
                'type' => 'success',
                'tmiPackages' => $tmiPremium,
                'message' => 'Calculated successfully.'
            ], 200);
        } else {
            return response()->json([
                'type' => 'success',
                'tmiPackages' => $tmiPremium,
                'message' => 'Calculation error.'
            ], 500);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        return ('hello');
        $this->TravelDatas();
        $data = $this->variable;
//        dd($data);
        return view('Backend.Travel.travel', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\TravelMedicalInsurance $travelMedicalInsurance
     * @return \Illuminate\Http\Response
     */
    public function show(TravelMedicalInsurance $travelMedicalInsurance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\TravelMedicalInsurance $travelMedicalInsurance
     * @return \Illuminate\Http\Response
     */
    public function edit(TravelMedicalInsurance $travelMedicalInsurance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TravelMedicalInsurance $travelMedicalInsurance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TravelMedicalInsurance $travelMedicalInsurance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\TravelMedicalInsurance $travelMedicalInsurance
     * @return \Illuminate\Http\Response
     */
    public function destroy(TravelMedicalInsurance $travelMedicalInsurance)
    {
        //
    }
}
