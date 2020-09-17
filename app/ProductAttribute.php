<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $table = 'product_attribute';
	
	protected $fillable = [
		'product_id',
		'attribute_id',
		'created_at',
		'update_at'
    ];

    protected $hidden = [];
	
	public function AttributeData(){
    	 return $this->hasOne('App\Attribute', 'id', 'attribute_id');
	}

	//Recap Relationship
	public function proddata(){
		return $this->belongsTo('App\Product','product_id','id');
	}

	public function AttrData(){
		return $this->hasMany('App\Attribute', 'id','attribute_id');
	}
	
	public function VarsData(){
		return $this->hasMany('App\Variable', 'id', 'attribute_id');
    }
}
