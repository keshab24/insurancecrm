<?php

namespace App\Http\Controllers;

use App\Mail\NonLifePolicy;
use App\Exports\PolicyExport;
use App\Models\CustomerPolicy;
use App\Models\GeneralSetting;
use App\Models\ImepayResponse;
use App\Models\KYC;
use App\Models\SmsResponse;
use App\Models\Lead;
use App\Models\MotorCalculationData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Auth;
use Exception;
use Illuminate\Support\Facades\Mail;
use Storage;
use \PDF;
use Redirect;
use Session;
use CURLFILE;
use function GuzzleHttp\Promise\all;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Log;

class NonLifeCalculatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function customerAjaxData()
    {
        $url = GeneralSetting::where('key', 'api_url')->first()->value;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/Api/KYC/GetKYCCategory",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $kycCat = json_decode(curl_exec($curl));
        $data['kycCategories'] = $kycCat->data ?? array();


        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/Api/KYC/GetInsuredType",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $insuredTypes = json_decode(curl_exec($curl));
        $data['insuredTypes'] = $insuredTypes->data ?? array();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/Api/KYC/getkycclassification",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $kycClassifications = json_decode(curl_exec($curl));
        $data['kycClassifications'] = $kycClassifications->data ?? array();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/Api/KYC/GetKYCRiskCategory",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $riskCategories = json_decode(curl_exec($curl));
        $data['riskCategories'] = $riskCategories->data ?? array();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/Api/Area/GetProvince",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $provinces = json_decode(curl_exec($curl));
        $data['provinces'] = $provinces->data ?? array();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/Api/KYC/GetKYCOccupation",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $kycOccupations = json_decode(curl_exec($curl));
        $data['kycOccupations'] = $kycOccupations->data ?? array();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/Api/KYC/GetIncomeSource",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $kycincomesources = json_decode(curl_exec($curl));
        $data['kycincomesources'] = $kycincomesources->data ?? array();

        curl_close($curl);
//        dd($data);
        return $this->variable = $data;
    }

    public function CalculatorData($dta)
    {
        $url = GeneralSetting::where('key', 'api_url')->first()->value;
        $datas = array(
            "ClassId" => $dta,
        );
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/Api/MotorSetup/GetExcessOwnDamage",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                                      "TYPECOVER":"",
                                        "VEHICLETYPE":"",
                                        "CATEGORYID":"",
                                        "CLASSCODE":""
                                    }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $data['excessdamages'] = json_decode(curl_exec($curl));

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/Api/MotorSetup/GetCategoryList",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($datas),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $data['categories'] = json_decode(curl_exec($curl));
//dd($data);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/Api/MotorSetup/GetMakeyearList",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                                       "NAMEOFVEHICLE":"20"
                                    }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $data['makeYearLists'] = json_decode(curl_exec($curl));

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/Api/MotorSetup/GetTypeofCoverList",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                                       "NAMEOFVEHICLE":""
                                    }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $data['typeCovers'] = json_decode(curl_exec($curl));

        curl_close($curl);
//        dd($data);
        return $this->variable = $data;
    }

    public function getCatType(Request $request)
    {
//        return $request;
        $url = GeneralSetting::where('key', 'api_url')->first()->value;

        $data = array(
            "CATEGORYID" => $request->CATEGORYID,
        );
//        dd($data);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/Api/MotorSetup/GetClassCategory",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $CategoryType = json_decode(curl_exec($curl));
        curl_close($curl);
//        dd($CategoryType);
        $CategoryTypeData = $CategoryType->data[0] ?? $output->Message;

        if ($CategoryType) {
            return response()->json([
                'type' => 'success',
                'CategoryType' => $CategoryTypeData,
                'message' => 'Calculated successfully.'
            ], 200);
        } else {
            return response()->json([
                'type' => 'error',
                'CategoryType' => '',
                'message' => 'Calculation error.'
            ], 500);
        }
//dd($data);
    }

    public function bikeCalculator(Request $request)
    {
        Session::forget('motorCalcId');
        $this->CalculatorData($request->classId ?? '');
        $data = $this->variable;
        return view('Backend.NonLife.bike.bikeCalculator', $data);
    }

    public function calculationMotor(Request $request)
    {
//        return $request;
        $data['stamp'] = 20;
        if ($request->EXPUTILITIESAMT < 100000) {
            $data['stamp'] = 10;
        }
        try {
            if ($request->CLASSID == 21) {
                Session::put('calculationFor', 'Bike');
            } elseif ($request->CLASSID == 22) {
                Session::put('calculationFor', 'Commercial Vehicle');
            } elseif ($request->CLASSID == 23) {
                Session::put('calculationFor', 'Private Vehicle');
            }
//        return $request;
//return (Session::get('calculationFor'));
            $url = GeneralSetting::where('key', 'api_url')->first()->value;
            $datas = array(
                "EXPUTILITIESAMT" => $request->EXPUTILITIESAMT ?? '0',
                "CATEGORYID" => $request->CATEGORYID,
                "CARRYCAPACITY" => $request->CARRYCAPACITY ?? '0',
                "YEARMANUFACTURE" => $request->YEARMANUFACTURE,
                "CCHP" => $request->CCHP,
                "EODAMT" => $request->EODAMT ?? '0',
                "PADRIVER" => $request->PADRIVER ?? '0',
                "PAPASSENGER" => $request->PAPASSENGER ?? '0',
                "PACONDUCTOR" => $request->PACONDUCTOR ?? '0',
                "NOOFEMPLOYEE" => $request->NOOFEMPLOYEE ?? '0',
                "NCDYR" => $request->NCDYR ?? '0',
                "NOOFPASSENGER" => $request->NOOFPASSENGER ?? '0',
                "PRIVATE_USE" => $request->PRIVATE_USE ?? '0',
                "INCLUDE_TOWING" => $request->INCLUDE_TOWING ?? '0',
                "ISGOVERNMENT" => $request->ISGOVERNMENT ?? '0',
                "TYPECOVER" => $request->TYPECOVER,
                "CLASSID" => $request->CLASSID,
                "HASAGENT" => $request->HASAGENT ?? '0',
                "EXCLUDE_POOL" => $request->EXCLUDE_POOL ?? '0',
                "compulsaryexcessamount" => $request->compulsaryexcessamount ?? '0',
                "Driver" => $request->Driver ?? '0',
                "PASSCAPACITY" => $request->PASSCAPACITY ?? '0',
            );
//        return $datas;

            $curl = curl_init();

            $kyc = array(
                "KYCNO" => Auth::user()->kyc->KYCID ?? '',
            );
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url . "/Api/KYC/GetKYCDetails",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($kyc),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $data['kycData'] = json_decode(curl_exec($curl));
//dd($data);
            $makeVehicle = array(
                "CLASSID" => $request->CLASSID,
            );
//            dd($makeVehicle);
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url . "/Api/MotorSetup/GetMakeVehicleList",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($makeVehicle),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $data['manufacturers'] = json_decode(curl_exec($curl));
//dd($data);
            $cat = array(
                "NAMEOFVEHICLE" => "",
            );
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url . "/Api/MotorSetup/GetMakeModel",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($cat),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $data['makeModels'] = json_decode(curl_exec($curl));

            $cat = array(
                "CLASSID" => $request->CLASSID,
            );
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url . "/Api/MotorSetup/GetVehicleNameList",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($cat),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $data['vehicleNames'] = json_decode(curl_exec($curl));


            $cat = array(
                "NAMEOFVEHICLE" => $request->CLASSID,
            );
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url . "/Api/MotorSetup/GetCategoryList",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($cat),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $data['categoryLists'] = json_decode(curl_exec($curl));


            // For Type Of Cover

            $typc = array(
                "NAMEOFVEHICLE" => $request->TYPECOVER,
            );
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url . "/Api/MotorSetup/GetTypeofCoverList",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($typc),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $data['typeCovers'] = json_decode(curl_exec($curl));

            //Occupation List
            $typc = array(
                "NAMEOFVEHICLE" => '',
            );
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url . "/Api/MotorSetup/GetOccupationList",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($typc),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $data['occupationLists'] = json_decode(curl_exec($curl));
//dd($datas);
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url . "/Api/Calculator/CalculateMotorPremium",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($datas),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $data['output'] = json_decode(curl_exec($curl));
//            dd($data['output']);
            $data['PremDetails'] = $data['output']->PremDetails ?? array();
            curl_close($curl);
            $data['requested_data'] = [$datas];
            $datas['user_id'] = Auth::user()->id;
            Session::forget('reqCalData');
            Session::put('reqCalData', $datas);
//            return (Session::get('reqCalData'));

//            dd($data);
            if ($data['output']) {
                return view('Backend.NonLife.bike.result', $data);
            } else {
                return redirect()->back()->withInput()->withErrors('Something went wrong. Please check your input values.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors('Something went wrong.' . $e->getMessage());
//            return $e->getMessage();
        }
    }

    function getModel(Request $request)
    {
        $datas = array(
            "MAKEVEHICLEID" => $request->mfComp,
        );
        $url = GeneralSetting::where('key', 'api_url')->first()->value;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/Api/MotorSetup/GetMakeModel",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($datas),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $output = json_decode(curl_exec($curl));
        $data['output'] = $output->data ?? $output->Message;

        curl_close($curl);
        return $data;
    }

    function random_strings($length_of_string)
    {
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        // Shufle the $str_result and returns substring
        // of specified length
        return substr(str_shuffle($str_result),
            0, $length_of_string);
    }

    public function selectCustomer(Request $request)
    {
        try {
//        return $request;
            $this->customerAjaxData();
            $data = $this->variable;
//        return $request;

            if ($request->file('bluebook_images')) {
                $path = $request->bluebook_images->store('motorBluebook', 'public');
                $imgFile = Storage::disk('public')->url($path);
                $request->merge(['bluebook_image' => $imgFile]);
            }
            if ($request->file('bike_images')) {
                $path1 = $request->bike_images->store('motorBike', 'public');
                $imgFile1 = Storage::disk('public')->url($path1);
                $request->merge(['bike_image' => $imgFile1]);
            }
            $request->merge(Session::get('reqCalData'));
//        dd($request);
            $calcData = '';
            if (!Session::get('motorCalcId')) {
                $calcData = MotorCalculationData::create($request->all());
                Session::forget('motorCalcId');
                Session::put('motorCalcId', $calcData->id);
            } else {
                $calcData = MotorCalculationData::find(Session::get('motorCalcId'))->update($request->except('_token'));
            }
//            dd($calcData);
            $data['formData'] = MotorCalculationData::find(Session::get('motorCalcId'))->only(['YEARMANUFACTURE', 'CCHP', 'CARRYCAPACITY', 'EXPUTILITIESAMT', 'compulsaryexcessamount', 'pool_premium', 'INCLUDE_TOWING', 'BUSSOCCPCODE', 'BASICPREMIUM_A', 'THIRDPARTYPREMIUM_B', 'DRIVERPREMIUM_C', 'HELPERPREMIUM_D', 'PASSENGERPREM_E', 'RSDPREMIUM_F', 'NETPREMIUM', 'THIRDPARTYPREMIUM', 'stamp', 'OTHERPREMIUM', 'TOTALVATABLEPREMIUM', 'TOTALNETPREMIUM', 'VAT', 'VATAMT', 'VEHICLENO', 'ENGINENO', 'CHASISNO', 'EODAMT', 'MODEUSE', 'REGISTRATIONDATE', 'payment_ref_id']);
            $data['makePolicy'] = '1';
            $data['customers'] = KYC::where('customer_id', '!=', '')->where('user_id', Auth::user()->id)->orderByDesc('id')->get();
//        dd($data);
            return view('Backend.NonLife.bike.selectCustomer', $data);
        } catch (\Exception $e) {
            return $data['data'] = $e->getMessage();
//            return view('Backend.NonLife.bike.selectCustomer', $data);
        }
    }

    public function paymentBikeFirstParty(Request $request)
    {
//        return $request;
        try {
            $kyc = KYC::where('customer_id', $request->customer_id)->first();
//        Session::put('KycId', $kyc->KYCID);
            if ($kyc) {
                $curl = curl_init();

                $refnumber = 'NB-' . $this->random_strings(5) . '-' . Carbon::now()->format('dmy');
                $url = GeneralSetting::where('key', 'ime_pay_token')->first()->value;
                $module = base64_encode(GeneralSetting::where('key', 'ime_module')->first()->value);
                $imeUser = base64_encode(GeneralSetting::where('key', 'ime_pay_username')->first()->value . ':' . GeneralSetting::where('key', 'ime_pay_user_password')->first()->value);
                $merchantCode = GeneralSetting::where('key', 'ime_merchant_code')->first()->value;
                $data['merchantCode'] = GeneralSetting::where('key', 'ime_merchant_code')->first()->value;
                $data['merchantName'] = GeneralSetting::where('key', 'ime_merchant_name')->first()->value;
                if (Session::get('motorCalcId')) {
                    $mtData = MotorCalculationData::whereId(Session::get('motorCalcId'))->first();
                    $pricePayable = $mtData->TOTALNETPREMIUM;
                }

                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "{ \"MerchantCode\":\"$merchantCode\", \"Amount\":\"$pricePayable\", \"RefId\":\"$refnumber\" } ",
                    CURLOPT_HTTPHEADER => [
                        'Content-Type: application/json',
                        'Authorization: Basic ' . $imeUser,
                        'Module: ' . $module
                    ],
                ));
                if (curl_exec($curl) === false) {
                    echo 'Curl error: ' . curl_error($curl);
                } else {
                    $response = curl_exec($curl);
//            dd($response);
                }
                $data['paymentInfo'] = json_decode($response);
                curl_close($curl);
                $data['ime_pay_checkout_url'] = GeneralSetting::where('key', 'ime_pay_checkout')->first()->value;
                $calcData = '';
//            dd($request);
                $storeDta = [
                    'customer_id' => $request->customer_id,
                    'payment_ref_id' => $data['paymentInfo']->RefId ?? '',
                    'payment_token_details' => json_encode($response) ?? '',
                ];
                if (Session::get('motorCalcId')) {
                    $calcData = MotorCalculationData::find(Session::get('motorCalcId'))->update($storeDta);
                }
                return view('Backend.NonLife.bike.payment', $data);
            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Kyc not Added ! Please Add the Kyc for the customer.'
                ], 200);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function compulsaryExcess(Request $request)
    {
        $url = GeneralSetting::where('key', 'api_url')->first()->value;
//        return $request;
        $datas = array(
            "TYPECOVER" => $request->TYPECOVER,
            "CATEGORYID" => $request->CATEGORYID,
            "YEARMANUFACTURE" => $request->YEARMANUFACTURE,
        );
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/Api/MotorSetup/GetCompulsoryExcess",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($datas),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $excessCal = json_decode(curl_exec($curl));
        curl_close($curl);
        $excessVal = $excessCal->data ? $excessCal->data[0]->CompulsoryExcess : '0';
        if ($excessVal > 0) {
            return response()->json([
                'type' => 'success',
                'CompulsoryExcess' => $excessVal,
                'message' => 'Calculated successfully.'
            ], 200);
        } else {
            return response()->json([
                'type' => 'success',
                'CompulsoryExcess' => $excessVal,
                'message' => 'Calculation error.'
            ], 200);
        }
    }

    public function excessDamage(Request $request)
    {
        $url = GeneralSetting::where('key', 'api_url')->first()->value;
//        return $request;
        $datas = array(
            "TYPECOVER" => $request->TYPECOVER,
            "CATEGORYID" => $request->CATEGORYID,
            "CLASSCODE" => $request->CLASSCODE,
            "VEHICLETYPE" => $request->VEHICLETYPE
        );
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/Api/MotorSetup/GetExcessOwnDamage",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($datas),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $excessdamages = json_decode(curl_exec($curl));

        curl_close($curl);

        $excessdamages = $excessdamages->data ? $excessdamages->data : '';
//        dd($excessdamages);
        if ($excessdamages) {
            return response()->json([
                'type' => 'success',
                'excessdamages' => $excessdamages,
                'message' => 'Calculated successfully.'
            ], 200);
        } else {
            return response()->json([
                'type' => 'success',
                'excessdamages' => $excessdamages,
                'message' => 'Calculation error.'
            ], 200);
        }
    }

    public function imePaySuccess(Request $request)
    {
        $curl = curl_init();
        $url = GeneralSetting::where('key', 'ime_pay_confirm')->first()->values;
        $module = base64_encode(GeneralSetting::where('key', 'ime_module')->first()->value);
        $imeUser = base64_encode(GeneralSetting::where('key', 'ime_pay_username')->first()->value . ':' . GeneralSetting::where('key', 'ime_pay_user_password')->first()->value);
        $merchantCode = GeneralSetting::where('key', 'ime_merchant_code')->first()->value;
        $data['merchantCode'] = GeneralSetting::where('key', 'ime_merchant_code')->first()->value;
        $data['merchantName'] = GeneralSetting::where('key', 'ime_merchant_name')->first()->value;
        $date = Carbon::now();
        $response = base64_decode($request->data);
        $pieces = explode("|", $response);
        $data['pieces'] = $pieces;
        $datas = array(
            "MerchantCode" => $data['merchantCode'],
            "RefId" => $pieces[4],
            "TokenId" => $pieces[6],
            "TransactionId" => $pieces[3],
            "Msisdn" => $pieces[2],
        );
//dd(json_encode($datas));
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($datas),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Basic ' . $imeUser,
                'Module: ' . $module
            ],
        ));
        $response = curl_exec($curl);
//            dd($response);
        if (curl_exec($curl) === false) {
//            echo 'Payment Validation error ' . curl_error($curl);
        } else {
            $response = curl_exec($curl);
        }
        $data['paymentInfo'] = json_decode($response);
        curl_close($curl);
//        dd($data);
        try {
            if (!ImepayResponse::where('RefId', '=', $pieces[4])->count()) {
                ImepayResponse::create([
                    "MerchantCode" => "INSURANCE",
                    "ImeTxnStatus" => $pieces[0],
                    "ResponseDescription" => $pieces[1],
                    "Msisdn" => $pieces[2],
                    "TransactionId" => $pieces[3],
                    "RefId" => $pieces[4],
                    "TranAmount" => $pieces[5],
                    "TokenId" => $pieces[6],
                    "RequestDate" => $date,
                    "ResponseDate" => $date,
                ]);
            }
            $storeDta = [
                'payment_url' => json_encode($request->data) ?? '',
                'status' => 1,
            ];
            if (Session::get('motorCalcId')) {
                $calcData = MotorCalculationData::find(Session::get('motorCalcId'))->update($storeDta);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
//            return redirect()->back();
        }
        $data['customers'] = Lead::where('is_user', 1)->get();
        $data['makePolicy'] = 1;
        return redirect()->route('nonLife.calculator.motor.make.policy', $data);
//        $this->makeOnlinePolicy($data);
//        return view('Backend.NonLife.bike.payment-result', $data);
    }

    public function imePayCancil(Request $request)
    {
        $data['customers'] = Lead::where('is_user', 1)->get();
        $data['merchantName'] = GeneralSetting::where('key', 'ime_merchant_name')->first()->value;
        $date = Carbon::now();
        $response = base64_decode($request->data);
        $pieces = explode("|", $response);
        $data['pieces'] = $pieces;
        try {
            if (!ImepayResponse::where('RefId', '=', $pieces[4])->count()) {
                ImepayResponse::create([
                    "MerchantCode" => "INSURANCE",
                    "ImeTxnStatus" => $pieces[0],
                    "ResponseDescription" => $pieces[1],
                    "Msisdn" => $pieces[2],
                    "TransactionId" => $pieces[3],
                    "RefId" => $pieces[4],
                    "TranAmount" => $pieces[5],
                    "TokenId" => $pieces[6],
                    "RequestDate" => $date,
                    "ResponseDate" => $date,
                ]);
            }
            $storeDta = [
                'payment_url' => json_encode($request->data) ?? '',
                'status' => 2,
            ];
            if (Session::get('motorCalcId')) {
                $calcData = MotorCalculationData::find(Session::get('motorCalcId'))->update($storeDta);
            }
        } catch (\Exception $e) {
            $e->getMessage();
//            return redirect()->back();
        }
        return view('Backend.NonLife.bike.payment-result', $data);
    }

    public function makeDraftPolicy(Request $request)
    {
        if ($request->policy_id && $request->reference_number && $request->status == 1) {
            $dta = CustomerPolicy::where('reference_number', $request->reference_number)->first();
            if ($dta && $dta->status == 1) {
                return redirect()->back()->withErrors('Policy Already Made');
            }
//            return ('payed');
            Session::forget('motorCalcId');
            Session::put('motorCalcId', $request->policy_id);
            return redirect()->route('nonLife.calculator.motor.make.policy');
        }
        if ($request->policy_id && !$request->reference_number) {
            $this->customerAjaxData();
            $data = $this->variable;
            Session::forget('motorCalcId');
            Session::put('motorCalcId', $request->policy_id);
            if (Session::get('motorCalcId')) {
                $data['formData'] = MotorCalculationData::find(Session::get('motorCalcId'))->only(['YEARMANUFACTURE', 'TYPECOVER', 'CCHP', 'CARRYCAPACITY', 'EXPUTILITIESAMT', 'compulsaryexcessamount', 'pool_premium', 'INCLUDE_TOWING', 'PRIVATE_USE', 'ISGOVERNMENT', 'HASAGENT', 'HAS_TRAILOR', 'BRANCHID', 'CLASSID', 'DEPTID', 'BUSSOCCPCODE', 'BASICPREMIUM_A', 'THIRDPARTYPREMIUM_B', 'DRIVERPREMIUM_C', 'HELPERPREMIUM_D', 'PASSENGERPREM_E', 'RSDPREMIUM_F', 'NETPREMIUM', 'THIRDPARTYPREMIUM', 'stamp', 'OTHERPREMIUM', 'TOTALVATABLEPREMIUM', 'TOTALNETPREMIUM', 'VAT', 'VATAMT', 'VEHICLENO', 'ENGINENO', 'CHASISNO', 'MAKEVEHICLEID', 'MAKEMODELID', 'MODEL', 'VEHICLENAMEID', 'EODAMT', 'MODEUSE', 'REGISTRATIONDATE', 'payment_ref_id', 'customer_id']);
            }
            $data['makePolicy'] = '1';
            $data['customers'] = KYC::where('customer_id', '!=', '')->where('user_id', Auth::user()->id)->orderByDesc('id')->get();
            return view('Backend.NonLife.bike.selectCustomer', $data);
        }
        if ($request->policy_id && $request->reference_number && $request->status == 0 || $request->policy_id && $request->reference_number && $request->status == 2) {
            $this->customerAjaxData();
            $data = $this->variable;
            Session::forget('motorCalcId');
            Session::put('motorCalcId', $request->policy_id);
            if (Session::get('motorCalcId')) {
                $data['formData'] = MotorCalculationData::find(Session::get('motorCalcId'))->only(['YEARMANUFACTURE', 'TYPECOVER', 'CCHP', 'CARRYCAPACITY', 'EXPUTILITIESAMT', 'compulsaryexcessamount', 'pool_premium', 'INCLUDE_TOWING', 'PRIVATE_USE', 'ISGOVERNMENT', 'HASAGENT', 'HAS_TRAILOR', 'BRANCHID', 'CLASSID', 'DEPTID', 'BUSSOCCPCODE', 'BASICPREMIUM_A', 'THIRDPARTYPREMIUM_B', 'DRIVERPREMIUM_C', 'HELPERPREMIUM_D', 'PASSENGERPREM_E', 'RSDPREMIUM_F', 'NETPREMIUM', 'THIRDPARTYPREMIUM', 'stamp', 'OTHERPREMIUM', 'TOTALVATABLEPREMIUM', 'TOTALNETPREMIUM', 'VAT', 'VATAMT', 'VEHICLENO', 'ENGINENO', 'CHASISNO', 'MAKEVEHICLEID', 'MAKEMODELID', 'MODEL', 'VEHICLENAMEID', 'EODAMT', 'MODEUSE', 'REGISTRATIONDATE', 'payment_ref_id', 'customer_id']);
            }
            $data['makePolicy'] = '1';
            $data['customers'] = KYC::where('customer_id', '!=', '')->where('user_id', Auth::user()->id)->orderByDesc('id')->get();
            return view('Backend.NonLife.bike.selectCustomer', $data);
        }
    }

    public function makeOnlinePolicy(Request $request)
    {
//        dd($request);
//            $policy = CustomerPolicy::where('reference_number', $request['pieces'][4] ?? '0')->first();
//        if ($policy && $request->paymnet_ref_id == $policy->reference_number){
//            return redirect()->back()->withErrors('Policy Already Made. Please Start Again to Add new policy');
//        }
        if (Session::get('motorCalcId')) {
            $calcData = MotorCalculationData::whereId(Session::get('motorCalcId'))->first();
        }
//                dd($calcData);
        $data['merchantCode'] = GeneralSetting::where('key', 'ime_merchant_code')->first()->value;
        $url = GeneralSetting::where('key', 'api_url')->first()->value;
//            "AGENTCODE" => Auth::user()->role_id == 5 ? '0738' : '0000',
        if ($calcData && $calcData['TYPECOVER'] == "TP") {
            $agentCode = "0000";
        } else {
            $agentCode = Auth::User()->userAgents->first()->liscence_number ?? '0000';
        }
//            dd($agentCode);
        $datas = array(
            "KYCID" => $calcData->customer->KYCID ?? "0000",
            "BRANCHID" => $calcData['BRANCHID'] ?? 1,
            "DEPTID" => $calcData['DEPTID'] ?? 1,
            "HASAGENT" => $calcData['HASAGENT'] ?? 0,
            "AGENTCODE" => $agentCode,
            "INCLUDE_TOWING" => $calcData['INCLUDE_TOWING'] ?? 0,
            "ISGOVERNMENT" => $calcData['ISGOVERNMENT'] ?? 0,
            "EXCLUDE_POOL" => $calcData['EXCLUDE_POOL'] ?? 0,
            "CLASSID" => $calcData['CLASSID'] ?? 21,
            "CATEGORYID" => $calcData['CATEGORYID'] ?? 0,
            "TYPECOVER" => $calcData['TYPECOVER'] ?? '',
            "BUSSOCCPCODE" => $calcData['BUSSOCCPCODE'] ?? 0,
            "MODEUSE" => $calcData['MODEUSE'] ?? '',
            "MAKEVEHICLEID" => $calcData['MAKEVEHICLEID'] ?? 0,
            "MAKEVEHICLE" => "cfO;",
            "HAS_TRAILOR" => $calcData['HAS_TRAILOR'] ?? 0,
            "MAKEMODELID" => $calcData['MAKEMODELID'] ?? 0,
            "MODEL" => $calcData['MODEL'] ?? '',
            "VEHICLENAMEID" => $calcData['VEHICLENAMEID'] ?? 0,
            "NAMEOFVEHICLE" => ":^f/ :sn a",
            "YEARMANUFACTURE" => $calcData['YEARMANUFACTURE'] ?? 0,
            "CCHP" => $calcData['CCHP'] ?? 0,
            "CARRYCAPACITY" => $calcData['CARRYCAPACITY'] ?? 0,
            "REGDATE" => $calcData['REGISTRATIONDATE'] ?? '',
            "EXPUTILITIESAMT" => $calcData['EXPUTILITIESAMT'] ?? 0,
            "UTILITIESAMT" => 0,
            "OGCPU" => true,
            "VEHICLENO" => $calcData['VEHICLENO'] ?? '',
            "RUNNINGVEHICLENO" => "",
            "EVEHICLENO" => $calcData['VEHICLENO'] ?? '',
            "ERUNNINGVEHICLENO" => "",
            "ENGINENO" => $calcData['ENGINENO'] ?? '',
            "CHASISNO" => $calcData['CHASISNO'] ?? '',
            "EODAMT" => $calcData['EODAMT'] ?? 0,
            "NOOFVEHICLES" => "0",
            "NCDYR" => $calcData['NCDYR'] ?? 0,
            "PADRIVER" => $calcData['PADRIVER'] ?? 0,
            "NOOFEMPLOYEE" => $calcData['NOOFEMPLOYEE'] ?? 0,
            "PACONDUCTOR" => $calcData['PACONDUCTOR'] ?? 0,
            "PACLEANER" => 0,
            "NOOFPASSENGER" => $calcData['NOOFPASSENGER'] ?? 0,
            "Driver" => $calcData['Driver'] ?? 0,
            "PASSCAPACITY" => $calcData['PASSCAPACITY'] ?? 0,
            "PAPASSENGER" => $calcData['PAPASSENGER'] ?? 0,
            "ESTCOST" => $calcData['EXPUTILITIESAMT'] ?? 0,
            "OTHERSI" => 0.00,
            "OTHERSIDESC" => "",
            "SHOWROOM" => 0,
            "Vehicleage" => 0,
            "BASICPREMIUM_A" => $calcData['BASICPREMIUM_A'] ?? 0,
            "THIRDPARTYPREMIUM_B" => $calcData['THIRDPARTYPREMIUM_B'] ?? 0,
            "DRIVERPREMIUM_C" => $calcData['DRIVERPREMIUM_C'] ?? 0,
            "HELPERPREMIUM_D" => $calcData['HELPERPREMIUM_D'] ?? 0,
            "PASSENGERPREM_E" => $calcData['PASSENGERPREM_E'] ?? 0,
            "RSDPREMIUM_F" => $calcData['RSDPREMIUM_F'] ?? 0,
            "PAIDAMT" => $calcData['TOTALNETPREMIUM'] ?? 0,
            "STAMPDUTY" => $calcData['stamp'] ?? 0,
            "VATRATE" => $calcData['VAT'] ?? 0,
            "VATAMT" => $calcData['VATAMT'] ?? 0,
            "COD" => $calcData['compulsaryexcessamount'] ?? 0,
            "MERCHANT_TRANS_NO" => $calcData['payment_ref_id'] ?? 0,
            "TRANS_DATE" => Carbon::now()->format('d-M-Y'),
            "MERCHANT_CODE" => "imepay@lmtrading",
            "MERCHANT_PASSWORD" => "",
            "TOTAL_PREMIUM_BEFORE_VAT" => $calcData['NETPREMIUM'] ?? 0,
            "customer_id" => $calcData->customer_id ?? 0,
            "status" => $calcData->status ?? 0,
            "user_id" => $calcData['user_id'] ?? 0,
            "FOCODE" => '0738'
        );
//            dd($datas);
        try {
            $curl = curl_init();
            $apiUser = base64_encode(GeneralSetting::where('key', 'api_username')->first()->value . ':' . GeneralSetting::where('key', 'api_user_password')->first()->value);

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url . "/api/Policy/MakeOnlinePolicy",
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
//dd($curl);
            $output = json_decode(curl_exec($curl));
//            dd($output);
            $data['output'] = $output ?? $output->message;
            $data['data'] = $output->data ?? $output->message;
//            dd($data);
            curl_close($curl);

            $datas['output'] = json_encode($data['data']);
            $datas['reference_number'] = $calcData['payment_ref_id'] ?? '0';
            $datas['newCstPolicy'] = CustomerPolicy::create($datas);
            return redirect()->route('nonLife.calculator.policy.done', $data);
//            dd($datas);
        } catch (\Exception $e) {
//            return $e->getMessage();
            $data['data'] = json_encode($output) ?? $e->getMessage();
            $data['output'] = $e->getMessage();
            $calcData->update(["payment_output" => json_encode($output)]);
//            $datas['reference_number'] = $calcData['payment_ref_id'] ?? '0';
//            $datas['newCstPolicy'] = CustomerPolicy::create($datas);
            return redirect(route('nonLife.calculator.policy.done', $data));
        }
    }

    public function policyDone(Request $request)
    {
        try {
            if (Session::get('motorCalcId')) {
                $url = GeneralSetting::where('key', 'api_url')->first()->value;
                $calcData = MotorCalculationData::whereId(Session::get('motorCalcId'))->first();
//            return $calcData;
                if ($calcData->bluebook_image || $calcData->bike_image) {
                    $datas = array(
                        'PolicyDetail' => json_encode([
                            "POLICYNO" => $request->data[0]['AcceptanceNo'] ?? '0'
                        ]),
                    );
                    if ($calcData->bluebook_image) {
                        $datas['bluebook'] = new CURLFILE($calcData->bluebook_image);
                    }
                    if ($calcData->bike_image) {
                        $datas['bike'] = new CURLFILE($calcData->bike_image);
                    }
//            return $datas;
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $url . "/Api/Policy/SavePolicyDocument",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => $datas,
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: multipart/form-data'
                        ),
                    ));
                    $document = json_decode(curl_exec($curl));
//            dd($document);

                    $customer_phone = $calcData->customer ? $calcData->customer->MOBILENO : '';
                    if (GeneralSetting::where('key', 'sms_activation')->first()->value && GeneralSetting::where('key', 'sms_activation')->first()->value == 1 && $customer_phone) {
                        $customer_name = strtok($request->data[0]['insured'], " ");
//                    $policy = str_replace('%20MC', '', preg_replace('/\s+/', '%20', $request->data[0]['ClassName']));
                        $message = 'Hi%20' . $customer_name . ',%0aYou%20have%20successfully%20purchased%20a%20policy%20of%20NRs.%20' . $request->data[0]['tpPremium'] . '%20for%20policy%20number:' . $request->data[0]['policyNo'] . '.%0aThank%20you%20for%20choosing%20Ebeema.';
//                        dd($message);
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => "https://sms.isplservices.com/smpp/sendsms?to=977" . $customer_phone . "&from=ISPL&text=" . $message,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                            CURLOPT_HTTPHEADER => array(
                                'Authorization: Basic ZGVtb2lzcGxodHAxOjE+WFk4MUV5OTNj'
                            ),
                        ));
//dd($curl);
                        $smsReply = curl_exec($curl);
//            dd ($smsReply);
                        if ($smsReply) {
                            $smsDta['customer_id'] = $calcData->customer_id ?? 'N/A';
                            $smsDta['reference_number'] = $calcData->payment_ref_id ?? 'N/A';
                            $smsDta['message'] = $message ?? 'N/A';
                            $smsDta['response'] = $smsReply ?? 'N/A';
                            SmsResponse::create($smsDta);
                        }
                    }
                    curl_close($curl);

                }
                $calcData->update(array('image_upload_status' => 1));
                CustomerPolicy::where('reference_number', $calcData->payment_ref_id)->first()->update(array('image_upload_status' => 1));
                // Send mail
//                dd(CustomerPolicy::where('reference_number',$calcData->payment_ref_id)->first());
                $customer_mail = $calcData->customer ? $calcData->customer->EMAIL : '';
                if ($customer_mail) {
                    Mail::to($customer_mail)
                        ->send(new NonLifePolicy(CustomerPolicy::where('reference_number', $calcData->payment_ref_id)->first()));
                }
                $calcData->delete();
            }
//        dd($calcData);
//            Session::put('motorCalcId', 118);
            Session::forget('motorCalcId');
            $data['output'] = $request->output;
            $data['data'] = $request->data;
            return view('Backend.NonLife.bike.policy', $data);
        } catch (\Exception $e) {
            $data['output'] = $request->output;
            $data['data'] = $request->data;
            return view('Backend.NonLife.bike.policy', $data);
        }
    }

    public function getDebitNote(Request $request)
    {
        try {
            $data['data'] = MotorCalculationData::find($request->motorId);
//        return $data;
            $pdf = PDF::loadView('Backend.NonLife.debit-note', $data);
            return $pdf->download('Draft-policy.pdf');
//        return view('Backend.NonLife.debit-note', $data);
        } catch (\Exception $e) {
            echo('Something went wrong, Cannot download PDF');
        }
    }

    public function loadPdf(Request $request)
    {
//        Log::channel('errors')->warning('Something could be going wrong.'.$request);

        $url = GeneralSetting::where('key', 'pdf_api_url')->first()->value;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/api/Reports/PreviewDocument?docid=" . $request->docid,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $pdf = json_decode(curl_exec($curl));
//        dd($pdf);

        curl_close($curl);
        if ($pdf != null && $pdf->filePath != "Error") {
            $filename = 'NB-' . $request->proformano . '.pdf';
            $tempImage = tempnam(sys_get_temp_dir(), $filename);
            copy($url . $pdf->filePath, $tempImage);

            return response()->download($tempImage, $filename);
        }
        return redirect()->back()->withErrors('Cannot Download PDF.');
//        return response('Cannot Download PDF');
//        return Redirect::to($url.$pdf->filePath);
    }

    public function carCalculator(Request $request)
    {
        Session::forget('motorCalcId');
        $this->CalculatorData($request->classId ?? '');
        $data = $this->variable;
//        dd($data);
        return view('Backend.NonLife.Car.carCalculator', $data);
    }

    public function commercialCarCalculator(Request $request)
    {
        Session::forget('motorCalcId');
        $this->CalculatorData($request->classId ?? '');
        $data = $this->variable;
        return view('Backend.NonLife.Car.commercialCarCalculator', $data);
    }

    public function viewPolicy(Request $request)
    {
        if ($request->download) {
            return Excel::download(new PolicyExport, 'policy-list.xlsx');
        }
        if (Auth::user()->role_id == 1) {
            $data['policies'] = CustomerPolicy::latest()->get();
        } else {
            $data['policies'] = CustomerPolicy::where('user_id', Auth::user()->id)->orderByDesc('id')->get();
        }
        return view('Backend.NonLife.policy-list', $data);
    }

    public function viewDraftPolicy(Request $request)
    {
//        if ($request->download) {
//            return Excel::download(new PolicyExport, 'policy-list.xlsx');
//        }
        if (Auth::user()->role_id == 1) {
            $data['policies'] = MotorCalculationData::latest()->get();
        } else {
            $data['policies'] = MotorCalculationData::where('user_id', Auth::user()->id)->orderByDesc('id')->get();
        }
        return view('Backend.NonLife.DraftPolicies.index', $data);
    }
}
