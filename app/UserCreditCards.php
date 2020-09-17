<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCreditCards extends Model
{
    protected $table = 'user_creditcards';
	
	protected $fillable = [
		'user_id',
		'type',
		'number',
		'holder',
		'expiry_date',
    ];
	
	public function UserData()
	{
		return $this->hasOne('App\User', 'id', 'user_id');
	}
}
