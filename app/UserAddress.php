<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'user_address';
	
	protected $fillable = [
		'user_id',
		'fullname',
		'mobile_num',
		'no_bldg_st_name',
		'brgy',
		'city_municipality',
		'province',
		'other_notes',
		'is_billing',
		'is_shipping',
    ];
}
