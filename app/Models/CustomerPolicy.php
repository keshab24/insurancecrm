<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'user_id','image_upload_status', 'reference_number', 'KYCID', 'BRANCHID', 'DEPTID', 'CLASSID', 'CATEGORYID', 'TYPECOVER', 'BUSSOCCPCODE', 'MODEUSE', 'MAKEVEHICLEID', 'MAKEVEHICLE', 'HAS_TRAILOR', 'MAKEMODELID', 'MODEL', 'VEHICLENAMEID', 'NAMEOFVEHICLE', 'YEARMANUFACTURE', 'CCHP', 'PASSCAPACITY', 'CARRYCAPACITY', 'REGDATE', 'EXPUTILITIESAMT', 'UTILITIESAMT', 'OGCPU', 'VEHICLENO', 'RUNNINGVEHICLENO', 'EVEHICLENO', 'ERUNNINGVEHICLENO', 'ENGINENO', 'CHASISNO', 'EODAMT', 'NOOFVEHICLES', 'NCDYR', 'PADRIVER', 'NOOFEMPLOYEE', 'PACONDUCTOR', 'PACLEANER', 'NOOFPASSENGER', 'PAPASSENGER', 'ESTCOST', 'OTHERSI', 'OTHERSIDESC', 'SHOWROOM', 'Vehicleage', 'BASICPREMIUM_A', 'THIRDPARTYPREMIUM_B', 'DRIVERPREMIUM_C', 'HELPERPREMIUM_D', 'PASSENGERPREM_E', 'RSDPREMIUM_F', 'PAIDAMT', 'STAMPDUTY', 'VATRATE', 'VATAMT', 'MERCHANT_TRANS_NO', 'TRANS_DATE', 'MERCHANT_CODE', 'MERCHANT_PASSWORD', 'TOTAL_PREMIUM_BEFORE_VAT', 'output', 'status'
];

    public function customer()
    {
        return $this->belongsTo(Lead::class, 'customer_id', 'id');
    }
    public function agent()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
