<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'brand';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'slug_name',
        'featured_img',
        'featured_img_banner'
    ];
	
	public function ProductByBrand(){
    	 return $this->hasMany('App\Product', 'brand_id', 'id')->inRandomOrder()->take(3);
    }
	
	public function UserBrandData()
	{
		return $this->hasMany('App\UserBrands', 'brand_id', 'id');
	}
}
