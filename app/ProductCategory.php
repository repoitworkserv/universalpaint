<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
   protected $table = 'product_category';
	
	protected $fillable = [
		'product_id',
		'category_id',
		'created_at',
		'update_at'
    ];

    protected $hidden = [];

	public function SameCategoryProduct(){
		return $this->hasMany('App\ProductCategory', 'category_id', 'category_id')->inRandomOrder()->take(10);
	}

	public function ProductDetails(){
    	 return $this->hasOne('App\Product', 'id', 'product_id');
	}

	public function CatData(){
		return $this->hasMany('App\Category', 'id', 'category_id');
   	}
}
