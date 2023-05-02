<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = "companies";
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'type', 'is_active'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function rate_products()
    {
        return $this->products()->where('category', '=', 'endowment')->get();
    }

    public function child_products()
    {
        return $this->products()->where('category', '=', 'children')->get();
    }

    public function dhan_bristi()
    {
        return $this->products()->where('category', '=', 'dhan-bristi')->get();
    }

    public function money_back()
    {
        return $this->products()->where('category', '=', 'money-back')
            ->select('id', 'company_id', 'name')
            ->get();
    }

    public function whole_life_products()
    {
        return $this->products()->where('category', '=', 'whole-life')->get();
    }

    public function education_products()
    {
        return $this->products()->where('category', '=', 'education')->get();
    }

    public function couple_plans()
    {
        return $this->products()
            ->where('category', 'couple')
            ->select('id', 'company_id', 'name')
            ->get();
    }

    public function benefits()
    {
        return $this->hasMany(Benefit::class);
    }
}
