<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOthers extends Model
{
    protected $table = 'product_others';
	
	protected $fillable = [
		'product_id',
		'title',
		'description',
		'prodothers_type',
		'created_at',
		'updated_at'
    ];

    protected $hidden = [];
}
