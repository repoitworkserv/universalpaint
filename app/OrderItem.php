<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_item';
	
	protected $fillable = [
		'order_id',
		'seller_id',
		'product_name',
		'product_details',
		'quantity',
		'price',
		'discount',
		'discount_type',
		'total_amount',
		'created_at',
		'update_at'
    ];

    protected $hidden = [];
	
	public function OrderData(){
    	 return $this->hasOne('App\Order', 'id', 'order_id');
    }
}
