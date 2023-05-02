<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoneyBack extends Model
{
    use HasFactory;
    protected $fillable=[
        'age','term', 'sum_assured', 'rate', 'loading_charge_id', 'discount_sa_id'
    ];
}
