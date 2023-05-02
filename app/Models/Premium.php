<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Premium extends Model
{
    use HasFactory;
    protected $fillable = [
		'age', 'term', 'sum_assured','rate','loadingcharge','discount_on_sa','term_rider_rate'
	];
}
