<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductBrochuresContent extends Model
{
    protected $table = 'product_brochures_content';
	
	protected $fillable = [
		'component',
		'content',
		'created_at',
		'update_at'
    ];
}
