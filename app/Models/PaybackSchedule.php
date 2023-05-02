<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaybackSchedule extends Model
{
    use HasFactory;
    protected $table = "payback_schedule";
    protected $fillable = [
        'term_year', 'payback_year', 'rate', 'company_id', 'product_id'
    ];
    public function companies(){
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function products(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
