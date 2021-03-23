<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
	
	protected $fillable = [
		'parent_id',
		'slug_name',
		'product_code',
		'product_type',
		'quantity',
		'brand_id',
		'description',
		'discount',
		'price',
		'rating',
		'is_sale',
		'sale_price',
		'promo_from',
		'promo_end',
		'shipping_width',
		'shipping_length',
		'shipping_weight',
		'shipping_height',
		'list_tab',
		'howtousetab_details',
		'deliveryopt_tab_details',
		'brochure_path',
		'safety_path',
		'technical_path',
		'created_at',
		'update_at'
    ];

    protected $hidden = [];
	
	public function ParentData(){
    	 return $this->hasOne('App\Product', 'id', 'parent_id');
    }
	
	public function ChildData(){
    	 return $this->hasMany('App\Product', 'parent_id', 'id');
    }
	
	public function BrandData(){
    	 return $this->hasOne('App\Brand', 'id', 'brand_id');
    }
	
	public function ProductCategoryData(){
		return $this->hasMany('App\ProductCategory', 'product_id', 'id');
	}

	public function ProductVariableData(){
		return $this->hasMany('App\ProductVariable', 'product_id', 'id');
	}

	public function ProductAttributeData(){
		return $this->hasMany('App\ProductAttribute', 'product_id', 'id');
	}

	public function ProductOverview(){
		return $this->hasMany('App\ProductOthers', 'product_id', 'id')->where('prodothers_type', 'overview');
	}

	public function ProductWishlist(){
		return $this->hasMany('App\UserWishlist', 'product_id', 'id');
	}

	// PARENT -> Child -> Product Attribute
	public function UsedAttribute() {
        return $this->hasManyThrough(
            'App\ProductAttribute',
            'App\Product',
            'parent_id',
            'product_id',
            'id',
            'id'
        )->groupBy('product_attribute.attribute_id');
	}
	
	// PARENT -> Child -> Product Variables
	public function UsedVariables() {
        return $this->hasManyThrough(
            'App\ProductVariable',
            'App\Product',
            'id',
            'product_id',
            'id',
            'id'
        )->groupBy('product_variable.variable_id');
	}

	public function ProductOthers(){
		return $this->hasMany('App\ProductOthers', 'product_id', 'id');
	}
	
	public function ProductImages(){
		return $this->hasMany('App\ProductImages', 'product_id', 'id');
	}

	public function ProductUserPrice()
	{
		return $this->hasMany('App\ProductUserPrice', 'product_id', 'id');
	}
}
