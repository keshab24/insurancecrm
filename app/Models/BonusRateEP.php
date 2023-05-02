<?php

namespace App\Models;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BonusRateEP extends Model
{
    protected $table = 'bonus_rate_for_endowment';
    use HasFactory;
    protected $fillable=[
        'first_year', 'second_year', 'term_rate','product_id', 'company_id'
    ];

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }


}
