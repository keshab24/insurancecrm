<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $table = 'leads';
    protected $fillable = [
        'lead_id',
        'leadsource_id',
        'leadtype_id',
        'sales_person_name',
        'customer_name',
        'province',
        'city',
        'street_ward',
        'phone',
        'email',
        'dob',
        'profession',
        'insurence_company_name',
        'policy_cat',
        'policy_sub_cat',
        'policy_type',
        'sun_insured',
        'maturity_period',
        'premium',
        'lead_transfer_req',
        'is_active',
        'province_id',
        'note',
        'city_id',
        'policy_doc',
        'identity_doc',
        'is_user'
    ];

    protected $hidden = ['created_at', 'updated_at'];
    public function leadsource(){
        return $this->belongsTo(LeadSource::class);
    }
    public function leadtype(){
        return $this->belongsTo(LeadType::class);
    }
    public function policy_subcat(){
        return $this->belongsTo(PolicySubCategory::class,'policy_sub_cat');
    }
    public function policytype(){
        return $this->belongsTo(PolicyType::class,'policy_type');
    }
    public function remarks(){
        return $this->hasMany(Remark::class);
    }
    public function events(){
        return $this->hasMany(Event::class);
    }
    public function meetings(){
        return $this->hasMany(Meeting::class);
    }
}
