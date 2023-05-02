<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    use HasFactory;

    protected $fillable=['association_type','image','status','name'];

    public function getImageAttribute($value){
        if ($value) {
            return 'images/association/' . $value;
        }
        return '/frontend/img/home/Frame 25.png';
    }
}
