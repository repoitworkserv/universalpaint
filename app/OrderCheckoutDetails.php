<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderCheckoutDetails extends Model
{
    protected $table = 'order_checkout_details';
	
	protected $fillable = [
		'order_id',
		'reference',
		'lot_house_no',
		'city',
		'province',
		'region',
		'lname',
		'fname',
		'mname',
		'birth_date',
		'contact_no',
		'created_at',
		'update_at'
    ];

    protected $hidden = [];
	
	public function ParentData(){
    	 return $this->hasOne('App\Order', 'id', 'order_id');
    }
	
	public function CityData(){
    	 return $this->hasOne('App\Shipping', 'id', 'city');
    }
}
