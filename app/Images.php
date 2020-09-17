<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $table = 'images';
	
	protected $fillable = [
		'original_name',
		'file_name',
		'created_at',
		'updated_at'
    ];

    protected $hidden = [];
	
	public function ProductImages2(){
		return $this->hasOne('App\ProductImages', 'images_id', 'id');
	}
}
