<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyType extends Model
{
    use HasFactory;

    protected $table = 'policy_types';
    protected $fillable = [
        'policy_cat_id',
        'subcat_id',
        'type',
        'is_active',
    ];

    protected $hidden =['created_at','updated_at'];
}
