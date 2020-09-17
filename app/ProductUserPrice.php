<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductUserPrice extends Model
{
    protected $table = 'product_user_price';
	
	protected $fillable = [
		'product_id',
		'user_types_id',
		'price',
		'discount_type',
		'created_at',
		'updated_at',
    ];

    protected $hidden = [];
}
