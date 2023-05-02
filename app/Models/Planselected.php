<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Planselected extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'product',
        'birth_date',
        'birth_month',
        'birth_year',
        'age',
        'term',
        'sum_assured',
        'mop',
        'feature',
        'premium',
        'bonus',
        'money_back',
        'fname',
        'lname',
        'phone',
        'phone_2',
    ];

    public function planproduct()
    {
        return $this->belongsTo(Product::class,'product');
    }

    
}
