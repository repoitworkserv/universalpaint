<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Config;
use Validator;
use Auth;
use App\UserImages;
use App\Product;
use App\Category;
use App\Variable;
use App\Brand;
use App\BrandData;
use App\ProductCategory;
use App\ProductAttribute;
use App\ProductVariable;
use App\ProductOthers;
use App\Images;
use App\ProductImages;
use App\UserTypes;
use App\ProductUserPrice;
use App\PostMetaData;

class ProductController extends Controller
{
   public function __construct()
    {
        //check permission
   
 
    	//sidebar session
		session(['getpage' => 'product']); 
    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$search_item = ($request->search_item) ? $request->search_item : '';
		$search_brand = ($request->search_brand) ? $request->search_brand : '';
		$productlist = Product::with('ProductOverview')->where('parent_id',0)->orderby('id','desc')->paginate(10);
 
		$terms = explode(" ", $search_item);
		$brand_id = Brand::get();
		switch($productlist) {
			 case ($search_brand && empty($search_item)):
				 $productlist = Product::with('ProductOverview')->where('parent_id',0)->where(function($si) use($search_brand){
					 $si->orWhere('brand_id', 'like', $search_brand.'%');
				 })->orderby('id','desc')->paginate(10);
				 break;
			 
			 case (empty($search_brand) && $search_item):
					 $productlist = Product::with('ProductOverview')->where('parent_id',0)->where(function($si) use($terms){
						 foreach($terms as $term){
							 $si->where('name', 'like', '%'.$term.'%');
						 }
					 })->orWhere(function ($si) use ($search_item){
							 $si->orWhere('product_code', 'like', '%'.$search_item.'%');
					 })->orderby('id','desc')->paginate(10);
				 break;
			 
			 case ($search_brand && $search_item):
					 $productlist = Product::with('ProductOverview')->where('parent_id',0)->where(function($si) use($search_item, $search_brand){
						 $si->where('name', 'like', '%'.$search_item.'%');
						 $si->orWhere('product_code', 'like', '%'.$search_item);
						 $si->orWhere('brand_id', 'like', $search_brand.'%');
					 })->orderby('id','desc')->paginate(10);
				 break;
 
			 default: 
				 $productlist = Product::with('ProductOverview')->where('parent_id',0)->orderby('id','desc')->paginate(10);
		}
		$id = Auth::id();
		$uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
		return view('admin.master-record.product.index',compact('uimage','productlist','search_item','brand_id', 'search_brand'));
	}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function create()
    {
       $categorylist 	= Category::with('SubCategory')->get();
       $brandlist 		= Brand::get(); 
       $variablelist 	= Variable::get(); 
       $product_type 	= Config::get('constants.product_type');
	   $discount_type 	= Config::get('constants.discount_type');
	   $usertypes 		= UserTypes::get();
	   $DateNow        	= date('m/d/Y');
	   
	   $id = Auth::id();
	   $uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
       return view('admin.master-record.product.create',compact('uimage','product_type','variablelist','brandlist','categorylist','discount_type','usertypes'));
	   
    }

    public function duplicate()
    {
    	
		
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {	
    	 $validator = Validator::make($request->all(), [
			'prodcode'            => 'required',						
			'prodname'            => 'required',
			'proddesc'            => 'required',
			'product_type'         => 'required',
			'categorylist'		  => 'required',
			'prod_brandname'	=> 'required'

		]);
		
        if($validator->fails()){
            $message = '';
            foreach($validator->errors()->all() as $error){
                $message .= $error."\r\n";
			}
			return redirect()->back()->withInput()->with('error',$message);
        } else {
        	
			//recheck if parent slug name exist 
			$parent_slug = '';
			$prodname = str_replace(' ~[\\\\/:*?"<>|]~','-',trim(strtolower($request->prodname))); 
			$parent_slug_arr = Product::where('slug_name',$prodname); 
			$parent_slug = $prodname;
			if($parent_slug_arr->count() > 0 ){
				$parent_slug_arr = Product::where('parent_id',0)->where('slug_name', 'like', '%' . $prodname . '%');
				$get_count = $parent_slug_arr->count() + 1;
				$parent_slug = $prodname.$get_count;
			}
        	
			$product_type = $request->product_type;
			$newproduct = new Product; 
			$newproduct->name   		 = $request->prodname;
			$newproduct->slug_name		 = $parent_slug;
			$newproduct->product_code 	 = $request->prodcode;
			$newproduct->description 	 = $request->proddesc;
			$newproduct->interior		 = $request->interior;
			$newproduct->exterior		 = $request->exterior;
			$newproduct->surface_preparation		 = $request->surface_preparation;
			$newproduct->industrial		 = $request->industrial;
			$newproduct->product_type 	 = $request->product_type;
			$newproduct->product_type 	 = $request->product_type;
			$newproduct->brand_id 		 = $request->prod_brandname;
			$newproduct->list_tab = $request->howtouse.','.$request->aboutbrand.','.$request->deliveropt;
			$newproduct->howtousetab_details = $request->htu_desc;
			$newproduct->deliveryopt_tab_details = $request->delopt_desc;
			
			//single product
			if($product_type == 'single'){
				
			
				$new_filename = '';
	            $allowedfileExtension   =['JPG','PNG','JPEG','jpg','png','jpeg'];
	            if($request->hasfile('upload_image')) {
	            	
					//check if file exist or there is changes in upload 
					if(!file_exists(public_path('img/products').$request->upload_image->getClientOriginalName())){
						$variation_upload_image   = $request->file('upload_image');
						$filename           = $variation_upload_image->getClientOriginalName();
		                $extension          = $variation_upload_image->getClientOriginalExtension();
		                $check              = in_array($extension,$allowedfileExtension);
		
		                if ($check) {
		                    $new_filename   = $this->getRegExp($filename); 
		                    $post_path      = public_path('img/products');	
		                    $variation_upload_image->move($post_path, $new_filename);
		                } else {
		                    $message = 'Invalid File Type';
		                }	
					}
				}
				
				$newproduct->quantity 		 = $request->single_product_qty;
				$newproduct->price 			 = $request->single_product_price;
				$newproduct->discount		 = $request->single_product_dscnt;
				$newproduct->discount_type	 = $request->single_product_dscnt_type;
				$newproduct->is_sale 		 = !empty($request->single_product_issale) ? $request->single_product_issale : 0;
				$newproduct->sale_price 	 = $request->single_product_saleprice;
				$newproduct->promo_start 	 = !empty($request->single_product_promofrom) ? date('Y-m-d', strtotime($request->single_product_promofrom)) : '0000-00-00';
				$newproduct->promo_end 		 = !empty($request->single_product_promoto) ? date('Y-m-d', strtotime($request->single_product_promoto)) : '0000-00-00';
				$newproduct->shipping_width  = $request->single_shipping_width;
				$newproduct->shipping_length = $request->single_shipping_length;
				$newproduct->shipping_weight = $request->single_shipping_weight;
				$newproduct->shipping_height = $request->single_shipping_height;
				$newproduct->keywords		 = $request->single_keywords;
				if(!empty($new_filename)){
					$newproduct->featured_image  = $new_filename;
				}
				if($newproduct->save()){  
					//product category saving
					$category = $request->categorylist;
					if(count($category) > 0){
						$prod_id = $newproduct->id;
						for($c=0;$c<count($category);$c++){
							$newproductcat = new ProductCategory;
							$newproductcat->product_id = $prod_id;
							$newproductcat->category_id = $category[$c];
							$newproductcat->save();
						}
					}else{
						$newproductcat = new ProductCategory;
						$newproductcat->product_id = $prod_id;
						$newproductcat->category_id = '1';
						$newproductcat->save();
					}
					$this->overview_gallery($request,$newproduct->id);
					
					//product user price
					$this->producUserPrice($request,$newproduct->id);
					
					
					
				   $message = 'New Product successfully added!';
				   return redirect()->action('Admin\ProductController@index')->with('success',$message);
				}else{
					return redirect()->back()->with('error',$message);	
				}
			}else if($product_type == 'multiple'){
				//multiple product
				$count_product  = count($request->variation_product_qty);
				//start for parent saving
				$new_filename = '';
	            $allowedfileExtension   =['JPG','PNG','JPEG','jpg','png','jpeg'];
	            if($request->hasfile('parent_upload_image')) {
	            	
					//check if file exist or there is changes in upload 
					if(!file_exists(public_path('img/products').$request->parent_upload_image->getClientOriginalName())){
						$variation_upload_image   = $request->file('parent_upload_image');
						$filename           = $variation_upload_image->getClientOriginalName();
		                $extension          = $variation_upload_image->getClientOriginalExtension();
		                $check              = in_array($extension,$allowedfileExtension);
		
		                if ($check) {
		                    $new_filename   = $this->getRegExp($filename); 
		                    $post_path      = public_path('img/products');	
		                    $variation_upload_image->move($post_path, $new_filename);
		                } else {
		                    $message = 'Invalid File Type';
		                }	
					}
				}
				
				$newproduct->quantity 		 = $request->parent_product_qty;
				$newproduct->price 			 = $request->parent_product_price;
				$newproduct->discount		 = $request->parent_product_dscnt;
				$newproduct->discount_type	 = $request->parent_product_dscnt_type;
				$newproduct->is_sale 		 = !empty($request->parent_product_issale) ? $request->parent_product_issale : 0;
				$newproduct->sale_price 	 = $request->parent_product_saleprice;
				$newproduct->promo_start 	 = !empty($request->parent_product_promofrom) ? date('Y-m-d', strtotime($request->parent_product_promofrom)) : '0000-00-00';
				$newproduct->promo_end 		 = !empty($request->parent_product_promoto) ? date('Y-m-d', strtotime($request->parent_product_promoto)) : '0000-00-00';
				$newproduct->shipping_width  = $request->parent_shipping_width;
				$newproduct->shipping_length = $request->parent_shipping_length;
				$newproduct->shipping_weight = $request->parent_shipping_weight;
				$newproduct->shipping_height = $request->parent_shipping_height;
				$newproduct->keywords		 = $request->parent_keywords;
				
				if(!empty($new_filename)){
					$newproduct->featured_image  = $new_filename;
				}
				// end for parent saving
			
				
				
				
				if($count_product > 0){ 
					if($newproduct->save()){
						$product_id = $newproduct->id;
						
						//overview
						$this->overview_gallery($request,$product_id);
						
						//product user price
						$this->producUserPrice($request,$newproduct->id);
						
						//for product parent category
						$category = $request->categorylist;
						if(count($category) > 0){
							for($c=0;$c<count($category);$c++){
								$newproductcat = new ProductCategory;
								$newproductcat->product_id = $product_id;
								$newproductcat->category_id = $category[$c];
								$newproductcat->save();
							}
						}else{
							$newproductcat = new ProductCategory;
							$newproductcat->product_id = $product_id;
							$newproductcat->category_id = '1';
							$newproductcat->save();
						}
						//for product parent variable
						$variable_opt_arr = $request->variable_opt_arr;
						$variable_opt_count = count($variable_opt_arr);
						if($variable_opt_count > 0){
								for($voa=0;$voa<$variable_opt_count;$voa++){
									$newproductvar = new ProductVariable;
									$newproductvar->product_id = $product_id;
									$newproductvar->variable_id = $variable_opt_arr[$voa];
									$newproductvar->save();
								}
						}
						$variation_attributes = $request->variation_attributes;
						
						for($m=0;$m<$count_product;$m++){
							
							$new_filename = '';
				            $allowedfileExtension   =['JPG','PNG','JPEG','jpg','png','jpeg'];
				            if($request->hasFile('variation_upload_image')) {
				                $variation_upload_image   = $request->file('variation_upload_image');
								if(array_key_exists($m, $variation_upload_image)){
									$variation_upload_image_arr = $variation_upload_image[$m];
									$filename           = $variation_upload_image_arr->getClientOriginalName();
					                $extension          = $variation_upload_image_arr->getClientOriginalExtension();
					                $check              = in_array($extension,$allowedfileExtension);
					
					                if ($check) {
					                    $new_filename   = $this->getRegExp($filename);
					                    $post_path      = public_path('img/products');	
					                    $variation_upload_image_arr->move($post_path, $new_filename);
					                } else {
					                    $message = 'Invalid File Type';
					                }
								}
									
							}
								
							$newproduct = new Product;
							$newproduct->parent_id       = $product_id;
							$newproduct->slug_name		 = $parent_slug;
							$newproduct->product_type 	 = $request->product_type;
							$newproduct->description	 = $request->variation_description[$m];
							$newproduct->quantity 		 = $request->variation_product_qty[$m];
							$newproduct->price 			 = $request->variation_product_price[$m];
							$newproduct->discount		 = $request->variation_product_dscnt[$m];
							$newproduct->discount_type	 = $request->variation_product_dscnt_type[$m];
							$newproduct->is_sale 		 = !empty($request->variation_product_issale[$m]) ? $request->variation_product_issale[$m] : 0;
							$newproduct->sale_price 	 = $request->variation_product_saleprice[$m];
							$newproduct->promo_start 	 = !empty($request->variation_product_promofrom[$m]) ? date('Y-m-d', strtotime($request->variation_product_promofrom[$m])) : '0000-00-00';
							$newproduct->promo_end 		 = !empty($request->variation_product_promoto[$m]) ? date('Y-m-d', strtotime($request->variation_product_promoto[$m])) : '0000-00-00';
							$newproduct->shipping_width  = $request->variation_shipping_width[$m];
							$newproduct->shipping_length = $request->variation_shipping_length[$m];
							$newproduct->shipping_weight = $request->variation_shipping_weight[$m];
							$newproduct->shipping_height = $request->variation_shipping_height[$m];
							$newproduct->keywords		 = $request->variation_keywords[$m];
							
							if(!empty($new_filename)){
								$newproduct->featured_image  = $new_filename;
							}
							
							if($newproduct->save()){ 
								$new_prod_id = $newproduct->id;
								$whole_count = $m+1;
								$attr_keys = ($whole_count * $variable_opt_count) - $variable_opt_count;
								
								//for child product category
								for($c=0;$c<count($category);$c++){ 
									$newproductcat = new ProductCategory;
									$newproductcat->product_id = $new_prod_id;
									$newproductcat->category_id = $category[$c];
									$newproductcat->save();
								}
								
								for($voa=0;$voa<$variable_opt_count;$voa++){ 
									//for child product variable
									$newproductvar = new ProductVariable;
									$newproductvar->product_id = $new_prod_id;
									$newproductvar->variable_id = $variable_opt_arr[$voa];
									$newproductvar->save();
									
									 
									//for child product attribute
									$newproductattr = new ProductAttribute;
									$newproductattr->product_id = $new_prod_id;
									$newproductattr->attribute_id = $variation_attributes[$attr_keys];
									$newproductattr->save();
									$attr_keys = $attr_keys + 1;
								}
								
								if($request->has('utype_id_child')){
									$utype_obj = UserTypes::get();
									$utype_count = $utype_obj->count();
									$utype_id_child = $request->utype_id_child;
									$utype_discntval_child = $request->utype_discntval_child;
									$utype_discnt_type_child = $request->utype_discnt_type_child;
									$init_arrkey = 0;
									for($ut=0;$ut<$utype_count;$ut++){
										$init_arrkey = $ut;
										
										if($m>0){
											$prodxutype = ($m*$utype_count);
											$init_arrkey = ($ut>0) ? $prodxutype+1 : $prodxutype;
											
										}
										
										$newproductuserprice = new ProductUserPrice;
										$newproductuserprice->product_id = $new_prod_id;
										$newproductuserprice->user_types_id = $utype_id_child[$init_arrkey];
										$newproductuserprice->price = $utype_discntval_child[$init_arrkey];
										$newproductuserprice->discount_type = $utype_discnt_type_child[$init_arrkey];
										$newproductuserprice->created_at = date('Y-m-d');
										
										$newproductuserprice->save();
									}
								}
								// product user discount per item
								
								
								
								
							}
								
						}
						$message = 'New Product successfully added!';
				   		return redirect()->action('Admin\ProductController@index')->with('success',$message);


					}else{
						return redirect()->back()->withInput()->with('error',$message);	
					}
				}
				
				
			}
			
			/*
			$variable = new Variable;
			$variable->name  = $request->variable_name;
			$variable->description  = $request->variable_description;
			$variable->created_at = date('Y-m-d h:i:s');
			if($variable->save()){
			$message = 'New Variable successfully added!';
			   return redirect()->action('Admin\VariableController@index')->with(array('status'=>'success','msg'=>$message));
			}*/
			return redirect()->back()->withInput()->with('success',$message);
        }
        //error on save       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $productdetails = Product::with('ProductCategoryData')->find($id);  
	   
	   if (empty($productdetails)){
			abort(404);
		}
	   $subproduct 		= Product::where('parent_id',$id)
	   					->with('ProductVariableData')
	   					->with('ProductAttributeData')
	   					->with('ProductUserPrice')->get(); 
	   $productcategory = ProductCategory::where('product_id',$id)->get();
	   $productvariable = ProductVariable::where('product_id',$id)->get(); //print_r($productvariable->toArray()); exit();
	   $productothers   = ProductOthers::where('product_id',$id)->where('prodothers_type','overview')->get();
	   $productimages   = ProductImages::where('product_id',$id)->with('ProductImagesData')->get();
	   $productuserprice = ProductUserPrice::where('product_id',$id)->get();
	   $usertypes 		= UserTypes::get();
       $categorylist 	= Category::with('SubCategory')->get();
       $brandlist 	    = Brand::get(); 
       $variablelist 	= Variable::with('AttributeData')->get();  
       $product_type 	= Config::get('constants.product_type');
	   $discount_type = Config::get('constants.discount_type');
	   $DateNow        = date('m/d/Y');
	   $id = Auth::id();
	   $uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
       return view('admin.master-record.product.edit',compact('uimage','productdetails','productcategory','productvariable','product_type','subproduct','variablelist','brandlist','categorylist','discount_type','productothers','productimages','usertypes','productuserprice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		
    	$validator = Validator::make($request->all(), [
            'prodcode'            => 'required',
		  	'prodname'            => 'required',
		  	'proddesc'            => 'required',
			'product_type'         => 'required',
			'prod_brandname'	=> 'required'
        ]);
        if($validator->fails()){
            $message = '';
            foreach($validator->errors()->all() as $error){
                $message .= $error."\r\n";
            }
        } else {  
        	$product_type = $request->product_type;
			$newproduct = Product::where('id',$id)->get(); 
			$newproduct = $newproduct[0];
			$parent_slug = str_replace(' ','-',trim(strtolower($request->prodname)));
			if(empty($newproduct->slug_name)){
				$prodname = str_replace(' ','-',strtolower($request->prodname)); 
				$parent_slug_arr = Product::where('slug_name',$prodname); 
				$parent_slug = $prodname;
				if($parent_slug_arr->count() > 0 ){
					$parent_slug_arr = Product::where('parent_id',0)->where('slug_name', 'like', '%' . $prodname . '%');
					$get_count = $parent_slug_arr->count() + 1;
					$parent_slug = $prodname.$get_count;
				}
				$brand_slugname = Brand::where('id',$request->prod_brandname)->first()['slug_name'];
				$newproduct->slug_name  = $brand_slugname.'-'.preg_replace('~[\\\\/:*?"<>|]~','',$parent_slug);
			}
			$newproduct->name   		 = $request->prodname;
			$newproduct->product_code 	 = $request->prodcode;
			$newproduct->description 	 = $request->proddesc;
			$newproduct->interior		 = $request->interior;
			$newproduct->exterior		 = $request->exterior;
			$newproduct->surface_preparation		 = $request->surface_preparation;
			$newproduct->industrial		 = $request->industrial;
			$newproduct->product_type 	 = $request->product_type;
			$newproduct->brand_id 		 = $request->prod_brandname;
			$newproduct->list_tab = $request->howtouse.','.$request->aboutbrand.','.$request->deliveropt;
			$newproduct->howtousetab_details = $request->htu_desc;
			$newproduct->deliveryopt_tab_details = $request->delopt_desc;
			 
			//single product
			if($product_type == 'single'){
				
				$new_filename = '';
	            $allowedfileExtension   =['JPG','PNG','JPEG','jpg','png','jpeg'];
	            if($request->hasfile('upload_image')) {
	            	
					//check if file exist or there is changes in upload 
					if(!file_exists(public_path('img/products').$request->upload_image->getClientOriginalName())){
						$variation_upload_image   = $request->file('upload_image');
						$filename           = $variation_upload_image->getClientOriginalName();
		                $extension          = $variation_upload_image->getClientOriginalExtension();
		                $check              = in_array($extension,$allowedfileExtension);
		
		                if ($check) {
		                    $new_filename   = $this->getRegExp($filename); 
		                    $post_path      = public_path('img/products');	
		                    $variation_upload_image->move($post_path, $new_filename);
		                } else {
		                    $message = 'Invalid File Type';
		                }	
					}
				}
            	$brand_slugname = Brand::where('id',$request->prod_brandname)->first()['slug_name'];
				$newproduct->slug_name  = $brand_slugname.'-'.preg_replace('~[\\\\/:*?"<>|]~','',$parent_slug);
				$newproduct->quantity 		 = $request->single_product_qty;
				$newproduct->price 			 = $request->single_product_price;
				$newproduct->discount		 = $request->single_product_dscnt;
				$newproduct->discount_type	 = $request->single_product_dscnt_type;
				$newproduct->is_sale 		 = !empty($request->single_product_issale) ? $request->single_product_issale : 0;
				$newproduct->sale_price 	 = $request->single_product_saleprice;
				$newproduct->promo_start 	 = !empty($request->single_product_promofrom) ? date('Y-m-d', strtotime($request->single_product_promofrom)) : '0000-00-000000-00-00';
				$newproduct->promo_end 		 = !empty($request->single_product_promoto) ? date('Y-m-d', strtotime($request->single_product_promoto)) : '0000-00-00';
				$newproduct->shipping_width  = $request->single_shipping_width;
				$newproduct->shipping_length = $request->single_shipping_length;
				$newproduct->shipping_weight = $request->single_shipping_weight;
				$newproduct->shipping_height = $request->single_shipping_height;
				$newproduct->keywords		 = $request->single_keywords;

				//new fields
				$newproduct->where_to_use	= $request->single_where_to_use;
				$newproduct->area		 	= $request->single_area;
				$newproduct->best_used_for	= $request->single_best_used_for;
				$newproduct->features		= $request->single_features;
				$newproduct->coverage		= $request->single_coverage;
				$newproduct->finish			= $request->single_finish;
				$newproduct->application	= $request->single_application;
				$newproduct->packaging		= $request->single_packaging;
				
				if(!empty($new_filename)){
					$newproduct->featured_image  = $new_filename;
				}
				if($newproduct->save()){  
					//product category saving
					$category = $request->categorylist;
					if(count($category) > 0){
						$newproductcat = ProductCategory::where('product_id',$id)->get();
						if($newproduct->count() > 0){
							//checking from existing to new records
							//delete if not match
							foreach($newproductcat as $npc){
								$is_exist = '0';	
								for($c=0;$c<count($category);$c++){
									if($category[$c] == $npc->category_id){
										$is_exist = '1';
									}
								}
								if($is_exist == '0'){
									$delproductcat = ProductCategory::find($npc->id)->delete();
								}
							}
							//get record if no rec add new item
							for($c=0;$c<count($category);$c++){
								$seekproductcat = ProductCategory::where('product_id',$id)->where('category_id',$category[$c])->get();
								if($seekproductcat->count() == 0){
									$newproductcat = new ProductCategory;
									$newproductcat->product_id = $id;
									$newproductcat->category_id = $category[$c];
									$newproductcat->save();
								}
							}
							
						}
					}
					$this->overview_gallery($request,$id);
					
					//product user price
					$this->producUserPrice($request,$id);
					
					
				   $message = 'Product successfully updated!';
				   return redirect()->action('Admin\ProductController@index')->with('success',$message);
				}else{
					return redirect()->back()->with('error',$message);	
				}
			}else if($product_type == 'multiple'){ 
				//multiple product
				$count_product  = count($request->variation_product_qty);
				
				
				//start for parent saving
				$new_filename = '';
	            $allowedfileExtension   =['JPG','PNG','JPEG','jpg','png','jpeg'];
	            if($request->hasfile('parent_upload_image')) {
	            	
					//check if file exist or there is changes in upload 
					if(!file_exists(public_path('img/products').$request->parent_upload_image->getClientOriginalName())){
						$variation_upload_image   = $request->file('parent_upload_image');
						$filename           = $variation_upload_image->getClientOriginalName();
		                $extension          = $variation_upload_image->getClientOriginalExtension();
		                $check              = in_array($extension,$allowedfileExtension);
		
		                if ($check) {
		                    $new_filename   = $this->getRegExp($filename); 
		                    $post_path      = public_path('img/products');	
		                    $variation_upload_image->move($post_path, $new_filename);
		                } else {
		                    $message = 'Invalid File Type';
		                }	
					}
				}
				$brand_slugname = Brand::where('id',$request->prod_brandname)->first()['slug_name'];
				$newproduct->slug_name  = $brand_slugname.'-'.preg_replace('~[\\\\/:*?"<>|]~','',$parent_slug);
				$newproduct->quantity 		 = $request->parent_product_qty;
				$newproduct->price 			 = $request->parent_product_price;
				$newproduct->discount		 = $request->parent_product_dscnt;
				$newproduct->discount_type	 = $request->parent_product_dscnt_type;
				$newproduct->is_sale 		 = !empty($request->parent_product_issale) ? $request->parent_product_issale : 0;
				$newproduct->sale_price 	 = $request->parent_product_saleprice;
				$newproduct->promo_start 	 = !empty($request->parent_product_promofrom) ? date('Y-m-d', strtotime($request->parent_product_promofrom)) : '0000-00-00';
				$newproduct->promo_end 		 = !empty($request->parent_product_promoto) ? date('Y-m-d', strtotime($request->parent_product_promoto)) : '0000-00-00';
				$newproduct->shipping_width  = $request->parent_shipping_width;
				$newproduct->shipping_length = $request->parent_shipping_length;
				$newproduct->shipping_weight = $request->parent_shipping_weight;
				$newproduct->shipping_height = $request->parent_shipping_height;
				$newproduct->keywords		 = $request->parent_keywords;
				if(!empty($new_filename)){
					$newproduct->featured_image  = $new_filename;
				}
				// end for parent saving
				
				if($count_product > 0){ 
					if($newproduct->save()){   
						$product_id = $newproduct->id;
						
						$this->overview_gallery($request,$product_id);
						//product user price
						$this->producUserPrice($request,$product_id);
						
						//for product parent category
						$category = $request->categorylist;
						if(count($category) > 0){  
							$newproductcat = ProductCategory::where('product_id',$id)->get();
							if($newproduct->count() > 0){   
								//checking from existing to new records
								//delete if not match
								foreach($newproductcat as $npc){
									$is_exist = '0';	
									for($c=0;$c<count($category);$c++){
										if($category[$c] == $npc->category_id){
											$is_exist = '1';
										}
									}
									if($is_exist == '0'){
										$delproductcat = ProductCategory::find($npc->id)->delete();
									}
								}
							}  
							//get record if no rec add new item
							for($c=0;$c<count($category);$c++){
								$seekproductcat = ProductCategory::where('product_id',$id)->where('category_id',$category[$c])->get();
								if($seekproductcat->count() == 0){
									$newproductcat = new ProductCategory;
									$newproductcat->product_id = $product_id;
									$newproductcat->category_id = $category[$c];
									$newproductcat->save();
								}
							}
							
						} 
						//for product parent variable
						$variable_opt_arr = $request->variable_opt_arr;
						$variable_opt_count = count($variable_opt_arr);
						if($variable_opt_count > 0){
							$newproductvar = ProductVariable::where('product_id',$id)->get();
							if($newproductvar->count() > 0){  
								//checking from existing to new records
								//delete if not match
								foreach($newproductvar as $npv){  
									$is_exist = '0';	
									for($v=0;$v<$variable_opt_count;$v++){
										if($variable_opt_arr[$v] == $npv->category_id){
											$is_exist = '1';
										}
									}
									if($is_exist == '0'){
										ProductVariable::find($npv->id)->delete();
									}
								}
							} 
							//get record if no rec add new item
							for($v=0;$v<$variable_opt_count;$v++){
								$seekproductcat = ProductVariable::where('product_id',$id)->where('variable_id',$variable_opt_arr[$v])->get();
								
								if($seekproductcat->count() == 0){
									$newproductvar = new ProductVariable;
									$newproductvar->product_id = $product_id;
									$newproductvar->variable_id = $variable_opt_arr[$v];
									$newproductvar->save();
								}
							}
						} 

						$variation_attributes = $request->variation_attributes;
						$subproduct = $request->variation_subprod;
						for($m=0;$m<$count_product;$m++){
							
							$new_filename = '';
				            $allowedfileExtension   =['JPG','PNG','JPEG','jpg','png','jpeg'];
				            if($request->hasFile('variation_upload_image')) {
				                $variation_upload_image   = $request->file('variation_upload_image'); 
				               
								if(array_key_exists($m, $variation_upload_image)){  
									if(count($variation_upload_image[$m]) > 0){
										if(!file_exists(public_path('img/products').$variation_upload_image[$m]->getClientOriginalName())){
											$variation_upload_image_arr = $variation_upload_image[$m];
											$filename           = $variation_upload_image_arr->getClientOriginalName();
							                $extension          = $variation_upload_image_arr->getClientOriginalExtension();
							                $check              = in_array($extension,$allowedfileExtension);
							
							                if ($check) {
							                    $new_filename   = $this->getRegExp($filename);
							                    $post_path      = public_path('img/products');	
							                    $variation_upload_image_arr->move($post_path, $new_filename);
							                } else {
							                    $message = 'Invalid File Type';
							                }
										}
									}

								}
									
							}




							$new_prod_id = $subproduct[$m];
							
							//existing product
							$exsproduct = Product::where('parent_id',$id)->get();
							if($exsproduct->count() > 0){
								//checking from existing to new records
								//delete if not match
								foreach($exsproduct as $exsprod){
									$is_exist = '0';	
									for($ep=0;$ep<count($subproduct);$ep++){
										if($subproduct[$ep] == $exsprod->id){
											$is_exist = '1';
										}
									}
									if($is_exist == '0'){
										Product::where('id',$exsprod->id)->delete();
									}
								}
							}
							
							
						
							$newproduct = Product::where('id',$new_prod_id)->get();
							if($newproduct->count() == 0){
								$newproduct = new Product;
								
								
								$parent_slug_arr = Product::where('id',$id)->get();
								$parent_slug_a = $parent_slug_arr[0];
								$newproduct->slug_name		 = $parent_slug_a->slug_name;
							}else{
								$newproduct = $newproduct[0]; 
								if(empty($newproduct->slug_name)){
									$newproduct->slug_name  = $parent_slug;
								}
							}
							
							
							
							$newproduct->parent_id       = $id;
							//$newproduct->slug_name		 = $parent_slug;
							$newproduct->description	 = $request->variation_description[$m];
							$newproduct->product_type 	 = $request->product_type;
							$newproduct->quantity 		 = $request->variation_product_qty[$m];
							$newproduct->price 			 = $request->variation_product_price[$m];
							$newproduct->discount		 = $request->variation_product_dscnt[$m];
							$newproduct->discount_type	 = $request->variation_product_dscnt_type[$m];
							$newproduct->is_sale 		 = !empty($request->variation_product_issale[$m]) ? $request->variation_product_issale[$m] : 0; 
							$newproduct->sale_price 	 = $request->variation_product_saleprice[$m]; 
							$newproduct->promo_start 	 = !empty($request->variation_product_promofrom[$m]) ? date('Y-m-d', strtotime($request->variation_product_promofrom[$m])) : '0000-00-00';
							$newproduct->promo_end 		 = !empty($request->variation_product_promoto[$m]) ? date('Y-m-d', strtotime($request->variation_product_promoto[$m])) : '0000-00-00';
							$newproduct->shipping_width  = $request->variation_shipping_width[$m];
							$newproduct->shipping_length = $request->variation_shipping_length[$m];
							$newproduct->shipping_weight = $request->variation_shipping_weight[$m];
							$newproduct->shipping_height = $request->variation_shipping_height[$m];
							$newproduct->keywords		 = $request->variation_keywords[$m];
							
							if(!empty($new_filename)){
								$newproduct->featured_image  = $new_filename;
							}
							
								
							if($newproduct->save()){
								//recheck sub prod id
								$new_prod_id = ($new_prod_id == 0 ? $newproduct->id:$new_prod_id); 
								$whole_count = $m+1;
								$attr_keys = ($whole_count * $variable_opt_count) - $variable_opt_count;
								
								
								//for product parent category
								$category = $request->categorylist;
								if(count($category) > 0){
									$addertag = 0;
									$newproductcat = ProductCategory::where('product_id',$new_prod_id)->get();
									if($newproduct->count() > 0){
										//checking from existing to new records
										//delete if not match
										foreach($newproductcat as $npc){
											$is_exist = '0';	
											for($c=0;$c<count($category);$c++){
												if($category[$c] == $npc->category_id){
													$is_exist = '1';
												}
											}
											if($is_exist == '0'){
												$delproductcat = ProductCategory::find($npc->id)->delete();
											}
										}
									}
									//get record if no rec add new item
									for($c=0;$c<count($category);$c++){
										$seekproductcat = ProductCategory::where('product_id',$new_prod_id)->where('category_id',$category[$c])->get();
										if($seekproductcat->count() == 0){
											$newproductcat = new ProductCategory;
											$newproductcat->product_id = $new_prod_id;
											$newproductcat->category_id = $category[$c];
											$newproductcat->save();
										}
									}
									
								}
								
								
								if($variable_opt_count > 0){
									$newproductvar = ProductVariable::where('product_id',$new_prod_id)->get();
									if($newproductvar->count() > 0){
										//checking from existing to new records
										//delete if not match
										foreach($newproductvar as $npv){
											$is_exist = '0';	
											for($v=0;$v<$variable_opt_count;$v++){
												if($variable_opt_arr[$v] == $npv->category_id){
													$is_exist = '1';
												}
											}
											if($is_exist == '0'){
												ProductVariable::find($npv->id)->delete();
											}
										}
									}
									//product attributes saving TO DO
									
									$newproductattr = ProductAttribute::where('product_id',$new_prod_id)->get();
									if($newproductattr->count() > 0){
										//checking from existing to new records
										//delete if not match
										foreach($newproductattr as $npa){
											$is_exist = '0';	
											for($v=0;$v<$variable_opt_count;$v++){
												if($variable_opt_arr[$v] == $npa->category_id){
													$is_exist = '1';
												}
											}
											if($is_exist == '0'){
												ProductAttribute::find($npa->id)->delete();
											}
										}
									}

									for($voa=0;$voa<$variable_opt_count;$voa++){ 
										//for child product variable
										
										//get record if no rec add new item
										
											$seekproductattr = ProductVariable::where('product_id',$new_prod_id)->where('variable_id',$variable_opt_arr[$voa])->get(); 
											if($seekproductcat->count() == 0){
												$newproductvar = new ProductVariable;
												$newproductvar->product_id = $new_prod_id;
												$newproductvar->variable_id = $variable_opt_arr[$voa];
												$newproductvar->save();
											}
										
										
										if(array_key_exists($attr_keys, $variation_attributes)){	
											//for child product attribute
											$seekproductattr = ProductAttribute::where('product_id',$new_prod_id)->where('attribute_id',$variation_attributes[$attr_keys])->get();
											if($seekproductattr->count() == 0){
												$seekproductattr = new ProductAttribute;
												$seekproductattr->product_id = $new_prod_id;
												$seekproductattr->attribute_id = $variation_attributes[$attr_keys];
												$seekproductattr->save();
										}		
                                            // dd($seekproductattr, $request->all());
                                            // print_r($seekproductattr);
                                            // echo '<br/>';
											$attr_keys = $attr_keys + 1; 
										}
										 
									}  

								}
								if($request->has('utype_id_child')){
									$utype_obj = UserTypes::get();
									$utype_count = $utype_obj->count();
									$utype_id_child = $request->utype_id_child;
									$utype_discntval_child = $request->utype_discntval_child;
									$utype_discnt_type_child = $request->utype_discnt_type_child;
                                	//dd($request->all(),$request->utype_discnt_type_child);
									$init_arrkey = 0;
									
									
									for($ut=0;$ut<$utype_count;$ut++){
										$init_arrkey = $ut;
										// $m count for subproduct
										if($m>0){
											$prodxutype = ($m*$utype_count);
											$init_arrkey = ($ut>0) ? $prodxutype+$ut : $prodxutype;
										
										}
										//check if exist
										$newproductuserprice = ProductUserPrice::where('product_id',$new_prod_id)->where('user_types_id',$utype_id_child[$init_arrkey])->get();
										
										if($newproductuserprice->count() == 0 ){
											$newproductuserprice = new ProductUserPrice;
										}else{
											$newproductuserprice = $newproductuserprice[0];
										}
										
										
										$newproductuserprice->product_id = $new_prod_id;
										$newproductuserprice->user_types_id = $utype_id_child[$init_arrkey];
										$newproductuserprice->price = $utype_discntval_child[$init_arrkey];
										$newproductuserprice->discount_type = $utype_discnt_type_child[$init_arrkey];
										$newproductuserprice->updated_at = date('Y-m-d');
										
										$newproductuserprice->save();
									}
								}
							} 
							
						}
						$message = 'New Product successfully Updated!';
				   		return redirect()->action('Admin\ProductController@index')->with('success',$message);


					}else{
						return redirect()->withInput()->back()->with('error',$message);	
					}
				}
				
				
			}
			
			
        }
        //error on save      
    	//dd(redirect()->withInput()->back()->with('error', $message));
    	$message = 'Please Check your Inputs data';
        return redirect()->withInput()->back()->with('error', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {	
		$featured_data = PostMetaData::where('meta_key','featured_products')->orWhere('meta_value', $id)->first();
		$hot_deals = PostMetaData::where('meta_key', 'hot_deals')->orWhere('meta_value', $id)->first();
		$message = '';
		$data_featured = explode(',', $featured_data->meta_value);
		$data_hot_deals = explode(',', $hot_deals->meta_value);
		switch($id) {
			case (in_array($id, $data_featured) && in_array($id, $data_hot_deals)):
				$status = 'info';
				$message =  'This are existing in Hot deals and Featured Products!';
			break;

			case (in_array($id, $data_hot_deals)):
				$status = 'info'; 
				$message = 'Hot Deals!';
				break;
			
			case (in_array($id, $data_featured)):
				$status = 'info';
				$message = 'Featured Product!';
				break;

			default:
				$delete =  Product::find($id)->delete();
        		$status = 'success';
				$message = 'Product successfully deleted!';
		}

		// if (empty($delete)){
		// 	abort(404);
		// }
        return redirect()->back()->with($status ,$message);
    }
	
	public function variation_details(Request $request)
	{
		$variable_id = $request->variable_id;
		$variablelist = Variable::where(function($query) use ($variable_id)
						{
							for ($vi=0;$vi<count($variable_id); $vi++)
						    {
						        $query->orWhere('id',$variable_id[$vi]);
						    }
						})
						->with('AttributeData')
						->get();
		echo json_encode($variablelist->toArray());
	}

	protected function getRegExp($name = ""){
		return preg_replace('/[^a-zA-Z0-9-_.\']/', '-', time()."-".$name);
	}

	public function overview_gallery($val, $product_id)
	{
		//overview
		$prod_ovrview = $val->ovrview_title;
		$prod_ovrview_desc = $val->ovrview_desc;   
		$prod_ovrview_count = count($prod_ovrview);
		if(!empty($prod_ovrview_count)){
			//recheck and delete existing record
			if($val->has('ovrview_id')){
				$existing_record = ProductOthers::where('product_id',$product_id)->where('prodothers_type','overview');
				
				if($existing_record->count() > 0){ 
					foreach($existing_record->get() as $er){ 
						if(!in_array($er->id, $val->ovrview_id)){ 
							ProductOthers::where('id',$er->id)->where('prodothers_type','overview')->delete();
						}
					}
					
				}
			}
			
			for($o=0;$o<$prod_ovrview_count;$o++){
				$prodothers = new ProductOthers; 
				if($val->has('ovrview_id')){
					if($val->ovrview_id[$o] != 0){
						$prodothers_data = ProductOthers::where('id',$val->ovrview_id[$o])->get();
						$prodothers = $prodothers_data[0];
					}
				}
				
				$prodothers->product_id = $product_id; 
				$prodothers->title = $prod_ovrview[$o];
				$prodothers->description = $prod_ovrview_desc[$o]; 
				$prodothers->prodothers_type = 'overview';
				$prodothers->created_at = date('Y-m-d');
				$prodothers->save();
			}
		}
		
		
		//recheck existing image
		if($val->has('gallery_img_id')){
			$gallery_img_id = $val->gallery_img_id;
			$get_prodimg = ProductImages::where('product_id',$product_id); 
			// if($get_prodimg->count() > 0){
			// 	foreach($get_prodimg->get() as $gpi){
			// 		if(!in_array($gpi->id, $gallery_img_id)){
			// 			ProductImages::where('id',$gpi->id)->delete();
			// 		}
			// 	}
			// }
		}
		
		
		$gallery_count = $val->gallery_img;
		if(!empty($gallery_count)){
			if(count($gallery_count) > 0) {
				for($g=0;$g<count($gallery_count);$g++){
					$new_filename = ''; 
					$allowedfileExtension   =['JPG','PNG','JPEG','jpg','png','jpeg'];
					if($val->hasFile('gallery_img')) { 
						$variation_upload_image   = $val->gallery_img;
						if(array_key_exists($g, $variation_upload_image)){  
							if(!empty($variation_upload_image[$g])){ 
								if(!file_exists(public_path('img/gallery').$variation_upload_image[$g]->getClientOriginalName())){
									$variation_upload_image_arr = $variation_upload_image[$g];
									$filename           = $variation_upload_image_arr->getClientOriginalName();
									$extension          = $variation_upload_image_arr->getClientOriginalExtension();
									$check              = in_array($extension,$allowedfileExtension);
									if ($check) {
										$new_filename   = $this->getRegExp($filename);
										$post_path      = public_path('img/gallery');	
										$variation_upload_image_arr->move($post_path, $new_filename);
										$imgtbl = new Images;
										$imgtbl->original_name = $filename;
										$imgtbl->file_name = $new_filename;
										$imgtbl->created_at = date('Y-m-d');
										if($imgtbl->save()){
											$image_id = $imgtbl->id;
											$prodimgs = new ProductImages;
											$prodimgs->product_id = $product_id;
											$prodimgs->images_id = $image_id;
											$prodimgs->image_gallery = $new_filename;
											$prodimgs->created_at = date('Y-m-d');
											$prodimgs->save();
										}		
									} else {
										$message = 'Invalid File Type';
									}
								}
							}
	
						}
							
					}
				}
			}
			return true;
		}
		
		return false;
	}

	public function deleteImage($id){
		$productImage = ProductImages::where('images_id',$id)->first();
		$productImage->delete();
		return response()->json([
			'success' => 'Record deleted successfully!'
		]);
	}

	public function producUserPrice($req, $product_id){
	
		$utype_id = $req->utype_id;
		$utype_discntval = $req->utype_discntval;
    	$utype_discnt_type = $req->utype_discnt_type;
		$check_exist = ProductUserPrice::where('product_id',$product_id);    //print_r($check_exist->get()->toArray());exit();
		if($check_exist->count() > 0){ 
			for($utype=0;$utype<count($utype_id);$utype++){
				$produserprice = new ProductUserPrice;
				$produserprice->created_at 		= date('Y-m-d');
				foreach($check_exist->get() as $ce){
					$user_types_id = $ce->user_types_id; 
					
					if($utype_id[$utype] == $user_types_id){  
						$get_indvdual = ProductUserPrice::where('id',$ce->id)->get(); 
						$produserprice = $get_indvdual[0];
						$produserprice->updated_at 		= date('Y-m-d');
						break;
					}
				}
				$produserprice->product_id 		= $product_id; 
				$produserprice->user_types_id 	= $utype_id[$utype]; 
				$produserprice->price 			= $utype_discntval[$utype];
				$produserprice->discount_type 	= $utype_discnt_type[$utype];
				
				$produserprice->save();
			}
			
		}else{
			
			for($pup=0;$pup<count($utype_id);$pup++){
				$produserprice = new ProductUserPrice;
				$produserprice->product_id 		= $product_id;
				$produserprice->user_types_id 	= $utype_id[$pup];
				$produserprice->price 			= $utype_discntval[$pup];
				$produserprice->discount_type 	= $utype_discnt_type[$pup];
				$produserprice->created_at 		= date('Y-m-d');
				$produserprice->save();
				
				
			}
		}
		return true;
	}
	

}
