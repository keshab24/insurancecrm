<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    public  $table = 'permissions';

    protected $fillable = ['id', 'name', 'display_name', 'description', 'created_at', 'updated_at',];
}
