<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role_id',
        'designation',
        'is_active',
        'image_icon',
        'agent',
        'ref_id',
        'phone_number',
        'company_details',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get role of the user
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function kyc()
    {
        return $this->hasOne(KYC::class, 'user_id', 'id');
    }

    public function userAgents()
    {
        return $this->hasMany(UserAgent::class, 'user_id', 'id');
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d F Y');
    }

}
