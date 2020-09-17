<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductVariable extends Model
{
   protected $table = 'product_variable';
	
	protected $fillable = [
		'product_id',
		'variable_id',
		'created_at',
		'updated_at'
    ];

    protected $hidden = [];
	
	public function VariableData(){
    	return $this->hasOne('App\Variable', 'id', 'variable_id');
	}
	//Recap Relationship
	public function proddata(){
		return $this->belongsTo('App\Product');
	}
	public function VarData(){
    	return $this->hasMany('App\Variable',  'id', 'variable_id');
	}
}
