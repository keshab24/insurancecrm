<?php

namespace App\Exports;

use App\Models\CustomerPolicy;
use Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PolicyExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view():view
    {
        if (Auth::user()->role_id == 1) {
            $data['policies'] =  CustomerPolicy::all();
        } else {
            $data['policies'] =  CustomerPolicy::where('user_id', Auth::user()->id)->orderByDesc('id')->get();
        }
        return view('Backend.NonLife.policy-list-table', $data);
    }

//    public function collection()
//    {
//        if (Auth::user()->role_id == 1) {
//            return CustomerPolicy::select('customer_id','reference_number', 'KYCID', 'TYPECOVER', 'YEARMANUFACTURE', 'CCHP', 'PASSCAPACITY', 'CARRYCAPACITY', 'REGDATE', 'EXPUTILITIESAMT', 'UTILITIESAMT', 'VEHICLENO', 'EODAMT', 'NCDYR', 'BASICPREMIUM_A', 'THIRDPARTYPREMIUM_B', 'DRIVERPREMIUM_C', 'HELPERPREMIUM_D', 'PASSENGERPREM_E', 'RSDPREMIUM_F', 'PAIDAMT', 'STAMPDUTY', 'VATRATE', 'VATAMT', 'TRANS_DATE', 'TOTAL_PREMIUM_BEFORE_VAT')->get();
//        } else {
//            return CustomerPolicy::where('user_id', Auth::user()->id)->orderByDesc('id')->select('customer_id','reference_number', 'KYCID', 'TYPECOVER', 'YEARMANUFACTURE', 'CCHP', 'PASSCAPACITY', 'CARRYCAPACITY', 'REGDATE', 'EXPUTILITIESAMT', 'UTILITIESAMT', 'VEHICLENO', 'EODAMT', 'NCDYR', 'BASICPREMIUM_A', 'THIRDPARTYPREMIUM_B', 'DRIVERPREMIUM_C', 'HELPERPREMIUM_D', 'PASSENGERPREM_E', 'RSDPREMIUM_F', 'PAIDAMT', 'STAMPDUTY', 'VATRATE', 'VATAMT', 'TRANS_DATE', 'TOTAL_PREMIUM_BEFORE_VAT')->get();
//        }
//    }
//
//    public function headings(): array
//    {
//        return [
//            'Customer','REFERENCE NUMBER', 'KYCID', 'TYPECOVER', 'YEAR MANUFACTURED', 'CCHP', 'PASS CAPACITY', 'CARRY CAPACITY', 'REGISTRATION DATE', 'EXPUTILITIES AMOUNT', 'UTILITIES AMOUNT', 'VEHICLE NUMBER', 'EOD AMOUNT', 'NO CLAIM DISCOUNT', 'BASIC PREMIUM', 'THIRDPARTY PREMIUM', 'DRIVER PREMIUM', 'HELPER PREMIUM', 'PASSENGER PREMIUM', 'RSD PREMIUM', 'PAID AMOUT', 'STAMP DUTY', 'VAT RATE', 'VAT AMOUNT', 'TRANSACTION DATE', 'TOTAL PREMIUM BEFORE VAT',
//        ];
//    }
}
