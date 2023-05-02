<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable=['name','designation','fb','image','twitter','linkedin','status'];

    public function getImageAttribute($value){
        if ($value) {
            return 'images/testimonial/' . $value;
        }
        return '/frontend/img/about/team1.png';
    }
}
