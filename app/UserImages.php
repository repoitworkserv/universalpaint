<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserImages extends Model
{
    protected $table = 'user_images';
	  
    protected $fillable = [
        'user_id',
        'images_id', 
    ];
	
	public function ImageData()
	{
		return $this->hasOne('App\Images', 'id', 'images_id');
	}
	public function UseData()
	{
		return $this->hasOne('App\User', 'id', 'user_id');
	}
}
