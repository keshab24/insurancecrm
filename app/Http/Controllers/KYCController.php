<?php

namespace App\Http\Controllers;

use App\Models\KYC;
use App\Models\GeneralSetting;
use App\Models\Lead;
use Illuminate\Http\Request;
use Storage;
use Auth;
use CURLFILE;
use Illuminate\Support\Facades\App;

class KYCController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function ajaxData()
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
//        dd($data['riskCategories']);

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

    public function index()
    {
        $this->ajaxData();
        $data = $this->variable;
//return  $data;
        return view('Backend.User.Kyc.index', $data);
    }

    public function customerKyc($id)
    {
        $this->ajaxData();
        $data = $this->variable;
        $data['customer'] = Lead::findOrFail($id);
//        return $data;
        return view('Backend.Leads.AllLeads.customer-kyc', $data);
    }


    public function getDistrict(Request $request)
    {
        $datas = array(
            "provinceID" => $request->provinceID,
        );
        $url = GeneralSetting::where('key', 'api_url')->first()->value;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/Api/Area/GetDistrict",
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

        $districts = json_decode(curl_exec($curl));
        $districts = $districts->data ?? array();
        curl_close($curl);
        return $districts;
    }

    public function getMnuVdc(Request $request)
    {
        $url = GeneralSetting::where('key', 'api_url')->first()->value;

        $curl = curl_init();
        $datas = array(
            "MNUVDCID" => "0",
            "DistrictID" => $request->DistrictID,
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/Api/Area/GetMNUVDC",
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

        $mnu = json_decode(curl_exec($curl));
        $data['mnu'] = $mnu->data ?? array();

        $mData = array(
            "MNUVDCID" => "1",
            "DistrictID" => $request->DistrictID,
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/Api/Area/GetMNUVDC",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($mData),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $vdc = json_decode(curl_exec($curl));
        $data['vdc'] = $vdc->data ?? array();
        curl_close($curl);
        return $data;
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
        $this->validate(
            $request,
            [
                'INSUREDNAME_ENG' => 'required',
                'INSUREDNAME_NEP' => 'required',
                'ADDRESS' => 'required',
                'MOBILENO' => 'exclude_if:phone_number,null|digits_between:10,13',
            ],
            [
                'INSUREDNAME_ENG.required' => 'Name Cannot Be Empty!!',
                'INSUREDNAME_NEP.required' => 'Nepali name Cannot Be Empty!!',
                'ADDRESS.required' => 'Address Cannot Be Empty!!',
                'MOBILENO.required' => 'Mobile number Cannot Be Empty!!',
            ]
        );

        $datas = $request->except('_token', 'photos', 'citfrnt', 'citback', 'cpmreg');
        $datas = array(
            'KYCDetails' => json_encode([$datas]),
        );
        if ($request->file('photos')) {
            $path = $request->photos->store('kycUploads', 'public');
            $imgFile = Storage::disk('public')->url($path);
            $datas['photos'] = new CURLFILE($imgFile);
            $request->merge(['photo' => $imgFile]);
        }
        if ($request->file('citfrnt')) {
            $path2 = $request->citfrnt->store('kycUploads', 'public');
            $imgFile2 = Storage::disk('public')->url($path2);
            $datas['citfrnt'] = new CURLFILE($imgFile2);
            $request->merge(['citfrntimg' => $imgFile2]);
        }
        if ($request->file('citback')) {
            $path3 = $request->citback->store('kycUploads', 'public');
            $imgFile3 = Storage::disk('public')->url($path3);
            $datas['citback'] = new CURLFILE($imgFile3);
            $request->merge(['citbackimg' => $imgFile3]);
        }
        if ($request->file('citback')) {
            $path4 = $request->cpmreg->store('kycUploads', 'public');
            $imgFile4 = Storage::disk('public')->url($path4);
            $datas['cpmreg'] = new CURLFILE($imgFile4);
            $request->merge(['cpmregimg' => $imgFile4]);
        }

//        return ($datas);
        $url = GeneralSetting::where('key', 'api_url')->first()->value;
        $apiUser = base64_encode(GeneralSetting::where('key', 'api_username')->first()->value . ':' . GeneralSetting::where('key', 'api_user_password')->first()->value);
        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url . "/Api/KYC/SaveKYC",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $datas,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: multipart/form-data',
                    'Authorization: Basic ' . $apiUser
                ),
            ));
//            dd ($curl);

            $kyc = json_decode(curl_exec($curl));
//            dd($kyc);
            curl_close($curl);
            if (isset($kyc->response_code) && $kyc->response_code == 1) {
                $request->merge(['KYCNO' => $kyc->KYCNO, 'KYCID' => $kyc->KYCID, 'user_id' => Auth::user()->id]);
                if (isset($request->is_ajax)) {
                    $data = array(
                        "is_user" => "1",
                        "customer_name" => $request->INSUREDNAME_ENG,
                        "phone" => $request->MOBILENO,
                        "email" => $request->EMAIL,
                        "sales_person_name" => Auth::user()->username,
                        "leadsource_id" => 1,
                        "leadtype_id" => 2,
                        "province" => $request->ZONEID,
                        "dob" => $request->DATEOFBIRTH,
                    );
                    $lead = Lead::create($data);
                    $request->merge(['customer_id' => $lead->id]);
                }
                $createdKyc = KYC::create($request->all());
//                dd($createdKyc);
                if (isset($request->is_ajax)) {
                    return response()->json([
                        'type' => 'success',
                        'message' => 'Successfully Added ! Please Select the customer.',
                        'data' => $createdKyc ?? '',
                    ], 200);
                }
                return redirect()->back()->withSuccessMessage($kyc->message);
            }
            if (isset($request->is_ajax)) {
                return response()->json([
                    'type' => 'error',
                    'message' => $kyc->Message ?? $kyc,
                ], 500);
            }
            return redirect()->back()->withErrorMessage($kyc->Message ?? $kyc);
        } catch (\Exception $e) {
            if (isset($request->is_ajax)) {
                return response()->json([
                    'type' => 'error',
                    'message' => $e->getMessage(),
                ], 500);
            }
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\KYC $kYC
     * @return \Illuminate\Http\Response
     */
    public function show(KYC $kYC)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\KYC $kYC
     * @return \Illuminate\Http\Response
     */
    public function edit(KYC $kYC)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\KYC $kYC
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KYC $kYC)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\KYC $kYC
     * @return \Illuminate\Http\Response
     */
    public function destroy(KYC $kYC)
    {
        //
    }
}
