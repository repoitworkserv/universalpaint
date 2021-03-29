<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
	
	protected $fillable = [
		'order_code',
		'customer_id',
		'invoice_no',
		'status',
		'amount',
		'amount_shipping',
		'amount_total',
		'amount_discount',
		'created_at',
		'updated_at'
    ];

    protected $hidden = [];
	
	public function OrderItemData(){
		return $this->hasMany('App\OrderItem', 'order_id', 'id');
	}
	public function OrderCheckoutDetailsData(){
		return $this->hasMany('App\OrderCheckoutDetails', 'order_id', 'id');
	}
	public function CUstomerData(){
		return $this->hasMany('App\User', 'id', 'customer_id');
	}
}
