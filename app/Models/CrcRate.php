<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrcRate extends Model
{
    use HasFactory;
    protected $fillable=[
        'age_id', 'one_time_charge', 'product_id', 'company_id'
    ];
    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function age(){
        return $this->belongsTo(Policy_age::class,'age_id');
     }
}
