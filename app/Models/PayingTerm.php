<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayingTerm extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }
}
