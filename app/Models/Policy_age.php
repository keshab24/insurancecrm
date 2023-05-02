<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy_age extends Model
{
    protected $table = 'policy_age';
    use HasFactory;
    public function age(){
        return $this->belongsTo(Rate_endowment::class,'age_id');
     }
}
