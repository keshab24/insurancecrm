<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * Database table used by the model.
     */
    protected $table = 'roles';

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name', 'display_name', 'description', 'created_at', 'updated_at', 'deleted_at', 'deleted_by'];

    public function role_user()
    {
        return $this->hasOne(Role_user::class, 'role_id', 'id');
    }

    public static function checkRole($id)
    {
        if ($id == null) return true;

        $role = static::findOrFail($id);
        return ($role) ? true : false;
    }

    /**
     * Attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get all users that belong to the role.
     */
    public function users()
    {
        return $this->hasMany('User', 'role_id');
    }
}
