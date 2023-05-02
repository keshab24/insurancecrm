<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoadingCharge extends Model
{
    use HasFactory;
    protected $fillable = [
		'yearly', 'half_yearly', 'quarterly','monthly','premium_rate','company_id', 'product_id'
    ];
    public function company(){
        return $this->belongsTo(Company::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }

}
