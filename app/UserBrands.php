<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBrands extends Model
{
    protected $table = 'user_brands';
	  
    protected $fillable = [
        'user_id',
        'brand_id', 
    ];
	
	public function BrandData()
	{
		return $this->hasOne('App\Brand', 'id', 'brand_id','hide_brand');
	}
	public function UseData()
	{
		return $this->hasOne('App\User', 'id', 'user_id');
	}

}
