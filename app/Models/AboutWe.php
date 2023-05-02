<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutWe extends Model
{
    use HasFactory;
    protected $fillable = ['about_us_title','about_us_content','image','title','description','is_definition'];

    public function getImageAttribute($value){
        if ($value) {
            return 'images/aboutus/' . $value;
        }
        return '/frontend/img/about/expert.png';
    }
}
