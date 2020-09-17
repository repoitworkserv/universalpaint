<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profile';
	
	protected $fillable = [
		'user_id',
		'first_name',
		'last_name',
		'birthdate',
		'age',
		'gender',
		'mobile_num',
		'tel_num'
    ];
	
	public function UserData(){
    	 return $this->hasOne('App\User', 'id', 'user_id');
    }
}
