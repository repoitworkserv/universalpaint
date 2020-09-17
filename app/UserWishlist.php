<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserWishlist extends Model
{
    protected $table = 'user_wishlist';
	
	protected $fillable = [
		'user_id',
		'product_id'
    ];
	
	public function ParentData(){
    	 return $this->hasOne('App\Product', 'id', 'product_id');
    }
}
