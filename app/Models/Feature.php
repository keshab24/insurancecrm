<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feature extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'code','is_active'];

    public function products()
    {
        return $this->hasMany(ProductFeature::class);
    }
    

}
