<?php

namespace App\Models;

use App\Models\Term;
use App\Models\Policy_age;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rate_endowment extends Model
{
    protected $table = 'rate_endowment';
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable=['rate','age_id','term_id','product_id','company_id','premium_paying_terms','created_by'];

    public function age(){
        return $this->belongsTo(Policy_age::class,'age_id');
     }
     public function term(){
        return $this->belongsTo(Term::class,'term_id');
     }
    public function companies(){
        return $this->hasMany(Company::class,'company_id','id');
    }
    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
