<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable=['name','designation','comment','image','rating','status'];

    public function getImageAttribute($value){
        if ($value) {
            return 'images/testimonial/' . $value;
        }
        return '/frontend/img/home/default-testimonial.png';
    }
}
