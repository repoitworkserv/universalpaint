<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'name',
        'description',
        'slug_name',
        'featured_img',
        'featured_img_bg',
        'featured_img_banner'
    ];
	
	public function SubCategory(){
    	return $this->hasMany('App\Category', 'parent_id', 'id');
    }

    public function ProdCatData(){
    	return $this->hasMany('App\ProductCategory', 'category_id', 'id');
    }
}
