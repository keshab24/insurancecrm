<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SumAssured extends Model
{
    use HasFactory;
    protected $table = 'discount_on_sa';
    protected $fillable = [
        'first_amount', 'second_amount', 'discount_value', 'company_id', 'product_id', 'plan'
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
