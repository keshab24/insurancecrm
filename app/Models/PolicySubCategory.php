<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicySubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'policy_cat_id',
        'subcat_name',
        'is_active',
    ];

    protected $hidden =['created_at','updated_at'];
}
