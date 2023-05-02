<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsResponse extends Model
{
    use HasFactory;

    protected $fillable = ['reference_number','customer_id','message','response'];
}
