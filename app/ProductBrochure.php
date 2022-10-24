<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductBrochure extends Model
{
    protected $table = 'product_brochures';
	
	protected $fillable = [
		'brochure_title',
		'brochure_image',
        'brochure_status',
		'created_at',
		'update_at'
    ];

    protected $hidden = [];
}
