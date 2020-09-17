<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    protected $table = 'product_images';
	
	protected $fillable = [
		'product_id',
		'images_id',
		'created_at',
		'updated_at'
    ];

    protected $hidden = [];
	
	public function ProductImagesData(){
		return $this->hasOne('App\Images', 'id', 'images_id');
	}
}
