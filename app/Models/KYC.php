<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KYC extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "know_your_customers";

    protected $fillable = ['user_id','customer_id', 'KYCNO', 'KYCID', 'CATEGORYID', 'INSUREDTYPE', 'kycclassification', 'KYCRiskCategory', 'INSUREDNAME_ENG', 'INSUREDNAME_NEP', 'ZONEID', 'DISTRICTID', 'MUNICIPALITYCODE', 'VDCCODE', 'ADDRESS', 'ADDRESSNEPALI', 'WARDNO', 'HOUSENO', 'PLOTNO', 'TEMPORARYADDRESS', 'NTEMPORARYADDRESS', 'HOMETELNO', 'MOBILENO', 'EMAIL', 'OCCUPATION', 'INCOMESOURCE', 'PANNO', 'GENDER', 'MARITALSTATUS', 'DATEOFBIRTH', 'CITIZENSHIPNO', 'ISSUE_DISTRICT_ID', 'ISSUEDATE', 'FATHERNAME', 'MOTHERNAME', 'GRANDFATHERNAME', 'GRANDMOTHERNAME', 'NFATHERNAME', 'NGRANDFATHERNAME', 'WIFENAME', 'photo', 'citfrntimg', 'citbackimg', 'cpmregimg', 'BRANCHCODE', 'ACCOUNTNAMECODE', 'AREAID', 'TOLEID'];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }
}
