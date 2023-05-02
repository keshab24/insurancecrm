<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhyUs extends Model
{
    use HasFactory;

    protected $fillable = ['why_us_title','why_us_content','image','title','description','is_definition'];

    public function getImageAttribute($value){
        if ($value) {
            return 'images/whyus/' . $value;
        }
        return '/frontend/img/home/whyusCopy.png';
    }
}
