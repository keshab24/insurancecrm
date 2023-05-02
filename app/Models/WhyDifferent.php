<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhyDifferent extends Model
{
    use HasFactory;
    protected $fillable = ['why_diff_title','why_diff_content','image','title','description','is_definition'];

    // Optional, by default will use table name
    protected $imageDirectory;

    public function getImageAttribute($value){
        if ($value) {
            return 'images/whyDifferent/' . $value;
        }
        return '/frontend/img/home/why-item.png';
    }
}
