<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductReviewsandRating extends Model
{
   protected $table = 'product_reviews_and_rating';
	
	protected $fillable = [
		'user_id',
		'product_id',
		'title',
		'reviews',
		'rate',
		'is_anonymous',
		'created_at',
		'updated_at',
    ];

    protected $hidden = [];
	
	public function UserData(){
    	return $this->hasOne('App\User', 'id', 'user_id');
	}
	public function ProductData(){
    	return $this->hasOne('App\Product', 'id', 'product_id');
	}
	public function UserProfileData(){
    	return $this->hasOne('App\UserProfile', 'user_id', 'user_id');
	}
}
