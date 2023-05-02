<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MotorCalculationData extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'user_id', 'customer_id','image_upload_status', 'CATEGORYID', 'YEARMANUFACTURE', 'TYPECOVER', 'CCHP', 'CARRYCAPACITY', 'EXPUTILITIESAMT', 'compulsaryexcessamount', 'pool_premium', 'INCLUDE_TOWING', 'PRIVATE_USE', 'ISGOVERNMENT', 'HASAGENT', 'HAS_TRAILOR', 'BRANCHID', 'CLASSID', 'DEPTID', 'BUSSOCCPCODE', 'PADRIVER', 'PAPASSENGER', 'NOOFEMPLOYEE', 'Driver', 'PASSCAPACITY', 'PACONDUCTOR', 'NOOFPASSENGER', 'BASICPREMIUM_A', 'THIRDPARTYPREMIUM_B', 'DRIVERPREMIUM_C', 'HELPERPREMIUM_D', 'PASSENGERPREM_E', 'RSDPREMIUM_F', 'NETPREMIUM', 'THIRDPARTYPREMIUM', 'stamp', 'OTHERPREMIUM', 'TOTALVATABLEPREMIUM', 'TOTALNETPREMIUM', 'VAT', 'VATAMT', 'VEHICLENO', 'ENGINENO', 'CHASISNO', 'MAKEVEHICLEID', 'EXCLUDE_POOL', 'NCDYR', 'MAKEMODELID', 'MODEL', 'VEHICLENAMEID', 'EODAMT', 'MODEUSE', 'REGISTRATIONDATE', 'payment_token_details', 'payment_ref_id', 'payment_url', 'payment_output', 'bluebook_image', 'bike_image', 'status'
    ];

    public function customer()
    {
        return $this->belongsTo(KYC::class, 'customer_id', 'customer_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
