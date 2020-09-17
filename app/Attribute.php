<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'attribute';
	
	protected $fillable = [
		'variable_id',		
		'name',
    ];

    
	
	public function VariableData()
	{
    	 return $this->hasOne('App\Variable', 'id', 'variable_id');
	}
	public function ProdAttrData()
	{
		return $this->hasMany('App\ProductAttribute','id','attribute_id');
	}
	public function ProductAttributeData()
	{
    	 return $this->hasMany('App\ProductAttribute', 'attribute_id', 'id');
    }
	
}
