<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'code',
        'type',
        'category',
        'company_id',
        'min_sum',
        'max_sum',
        'min_maturity_age',
        'max_maturity_age',
        'is_active',
        'has_loading_charge_on_features',
        'premium_rate_divider'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function rates()
    {
        return $this->hasMany(Rate_endowment::class, 'product_id');
    }

    public function features()
    {
        return $this->hasMany(ProductFeature::class, 'product_id');
    }

    public function terms()
    {
        return $this->rates()->groupBy('term_id')->pluck('term_id')->toArray();
    }

    public function paying_term()
    {
        return $this->hasMany(PayingTerm::class);
    }

    public function feature_rates()
    {
        return $this->hasManyThrough(ProductFeatureRates::class, ProductFeature::class);
    }
}
