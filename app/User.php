<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\CanResetPassword;


use App\Role;
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $table = 'users';
	  
    protected $fillable = [
        'role_id','name', 'email', 'password', 'permission',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPermissionAttribute()
    {
        $RoleID = \Auth::user()->role_id;
        $Role = Role::find($RoleID);
        $this->attributes['permission'] = $Role->permission;
    }

    public function getPermissionAttribute()
    {
        $RoleID = \Auth::user()->role_id;
        $Role = Role::find($RoleID);                
        return $Role->permission;
    }
	
	public function UserBrandData()
	{
		return $this->hasMany('App\UserBrands', 'user_id', 'id');
	}

}