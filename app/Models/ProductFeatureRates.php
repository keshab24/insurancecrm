<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductFeatureRates extends Model
{
    use HasFactory ,  SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable=['rate','age_id','term_id','product_feature_id'];

    public function age(){
        return $this->belongsTo(Policy_age::class,'age_id');
     }
     public function term(){
        return $this->belongsTo(Term::class,'term_id');
     }
}
