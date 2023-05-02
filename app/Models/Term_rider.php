<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Term_rider extends Model
{
    protected $table = 'term_riders';
    use HasFactory, SoftDeletes;
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
