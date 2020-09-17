<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    protected $table = 'variable';
	
	protected $fillable = [
		'name',
		'description'
    ];

    protected $hidden = [];
	
	public function AttributeData(){
    	 return $this->hasMany('App\Attribute', 'variable_id', 'id');
	}
	public function ProdVarData(){
		return $this->belongsTo('App\ProductVariable');
	}
	
	public function ProductVariableData(){
    	 return $this->hasMany('App\ProductVariable', 'variable_id', 'id');
    }
}
