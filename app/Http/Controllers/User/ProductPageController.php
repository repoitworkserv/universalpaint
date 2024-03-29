<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;

//Model
use App\PaymentMethod;
use App\Product;
use App\ProductCategory;
use App\ProductOthers;
use App\User;

use App\Variable;
use App\ProductAttribute;
use App\ProductImages;
use App\Attribute;
use App\Brand;
use App\UserBrands;
use App\Category;
use App\ProductReviewsandRating;
use App\UserWishlist;
use App\PostMetadata;
use App\ProductUserPrice;

use Validator;
use DB;
use Config;
use App\UserProfile;
use Session;
use File;

class ProductPageController extends Controller
{

    /**
     * Display a listing of the products.
     *
     * @param  \App\Http\Requests\PaginationRequest $request
     * @return \Response
     */
    public function index(Request $request)
    {   
        $sale_tag = '1';
        $sort = "";
        $search = "";
        $myfilter = $request->session()->get('myfilter'); 
        $myfilter =  $request->session()->forget('myfilter.');
    //    print_r($myfilter); exit();
        $getFiltered = array();
        $brandfltr = array();
        $getAttrs = array();
        $getBrandwhere = array();
        $pricefltr = array();
        $ratingfltr = array();
        $getProductwhere = array();
        $myfilter = array();

        //userProduct
        $uBp = array();
        //this for the hotdeals query
        $post = PostMetadata::all();
        $hotdeals = $post->get(1)->meta_value;
        $explode_id = array_map('intval', explode(',', $hotdeals));
        $productshotdeals = Product::whereIn('id', $explode_id)->paginate(12);
        if (!empty(array_filter($myfilter)) > 0) {
            foreach ($myfilter as $filters) {
                foreach ($filters as $val) {
                    $exp = explode(': ', $val);
                    if ($exp[0] != "brand" && $exp[0] != "price" && $exp[0] != "rating") {
                        $getFiltered[] = $exp[1];
                    }
                    if ($exp[0] == "brand") {
                        $brandfltr[] = $exp[1];
                    }
                    if ($exp[0] == "price") {
                        $pricefltr[] =  $exp[1];
                    }
                    if ($exp[0] == "rating") {
                        $ratingfltr[] =  $exp[1];
                    }
                }
            }
            //For Brands Filter
            for ($b = 0; $b < count($brandfltr); $b++) {
                $brands = $brandfltr[$b];
                $prodAttr = Product::whereHas('BrandData', function ($q) use ($brands) {
                    $q->where('slug_name', $brands);
                })->first();
                $getBrandwhere[] = $prodAttr->brand_id;
                $getProductwhere[] = $prodAttr->id;
            }

            //For Variables with Attributes Filter
            for ($f = 0; $f < count($getFiltered); $f++) {
                $productsAttr = Attribute::with('ProductAttributeData')->where('name', $getFiltered[$f])->first();
                if (isset($productsAttr->ProductAttributeData)) {
                    foreach ($productsAttr->ProductAttributeData as $prodAttrs) {
                        $getParent = Product::where('id', $prodAttrs->product_id)->first();
                        $getAttrs[] = $getParent->parent_id;
                    }
                }
            }
        }else{
            $prodAttr = Product::with('BrandData')->get();
            foreach($prodAttr as $prodAttrRow){
                $getBrandwhere[] = $prodAttrRow->brand_id;
                $getProductwhere[] = $prodAttrRow->id;
            }
        }
        $getCategory = Category::whereHas('ProdCatData', function($q) use($getProductwhere){
            $q->whereHas('CatData', function($qq) use($getProductwhere){
                $qq->whereIn('product_id', $getProductwhere);
            });
        })->get();
        $variables = Variable::with('AttributeData')->get(); // Color Filter
        $uid = Auth::id();
        $userBrands = UserBrands::where('user_id',$uid)->pluck('brand_id')->all();
        $userBran = Brand::where('hide_brand',0)->get();
    	foreach($getBrandwhere as $itemBrand){
            if(in_array($itemBrand, $userBrands)){
                array_push($uBp, $itemBrand);
            }
        }
        $getBrand = Product::with('BrandData')->where('parent_id', 0)->groupBy('brand_id')->get();
        $products = Product::where(function($q) use($getAttrs,$getBrandwhere,$pricefltr,$getFiltered,$ratingfltr,$uBp){
            $q->where('parent_id',0);

            if (count($getFiltered) > 0) {
                $q->whereIn('id', $getAttrs);
            }

            if (count($uBp) > 0) {
                $q->whereIn('brand_id', $uBp);
            }

            if(count($pricefltr) > 0){
                foreach($pricefltr as $priceVal){
                    $exprice = explode('-',$priceVal);
                    $q->where('price', '>=', $exprice[0]);
                    $q->where('price', '<=', $exprice[1]);
                }
            }
            if (count($ratingfltr) > 0) {
                foreach ($ratingfltr as $rateVal) {
                    $exrate = explode('-', $rateVal);
					// $q->where('rating', '>=', $exrate[0]);
					// $q->where('rating', '<=', $exrate[1]);
					// $q->where('rating', '>=', $exrate[0]);
					$q->where('rating', '>=', $rateVal);
                }
            }
           
        });
        $allProducts = $products->get();
        $products = $products->paginate(12);
        $productsRangePrice = Product::where('parent_id', 0)->max('price');
        $products->appends(['sort'=>$sort,'s'=>$search])->fragment('prodlist')->render(); 
		$uid = Auth::id();
        return view('user.product.index')->with(array(
            'countProducts' => $allProducts,
            'products' => $productshotdeals,
            'search' => $search,
            'sort' => $sort,
            'myfilter' => !empty($myfilter) ? array_filter($myfilter) : $myfilter,
            'type' => 'ps',
        	'userBrands' => $userBrands,
            'brands' => $getBrand,
            'variables' => $variables,
            'productsRangePrice' => ($productsRangePrice * 2),
            'pricesRnge' => (!empty($pricefltr[0])?explode('-',$pricefltr[0]):''),
            'page' => 'products',
            'ratingRnge' => (isset($ratingfltr[0]) ? $ratingfltr[0]:''),
            'getCategory' => $getCategory,
            'uid'=>$uid
        ));

    }
    
    public function details($slug_name, Request $request)
    { 
        // $productAttributes = array();        
        $cart = $request->session()->get('cart');
        $product = Product::with(['BrandData'=>function($query){
                $query->with('ProductByBrand');
            }])
            ->with(['UsedVariables'=>function($query){
                $query->with('VariableData');
            }])
            ->with(['UsedAttribute'=>function($query){
                $query->with('AttributeData');
            }])
            ->with(['ParentData'=>function($query){
                $query->with('BrandData');
            }])
            ->with(['ChildData'=>function($query){
                $query->groupBy('featured_image');
            }])
            ->with(['ProductCategoryData'=>function($query){
                // $query->with('SameCategoryProduct');
                $query->with(['SameCategoryProduct'=>function($querytwo){
                    $querytwo->with(['ProductDetails'=>function($querythree){
                    	$querythree->where('parent_id',0);
                    }]);
                }]);
            }])
            ->with('ProductOverview')
            ->with(['ProductWishlist'=>function($query){
                $query->where('user_id', Auth::id());
            }])
            // ->with('ChildData')
            ->where('slug_name','=',$slug_name)
            ->where('parent_id','=',0)
            ->get();
            //dd($product);
        $minsaleprice = Product::where('slug_name', $slug_name)->min('sale_price');
        $highprice = Product::where('slug_name', $slug_name)->max('price');
        $uid = Auth::id();
        // $user_type_id = User::where('id', $uid)->first()['users_type_id'];
		$product_rev = Product::where('parent_id',0)->where('slug_name',$slug_name); 
        $product_id = ($product->count() > 0 ? $product_rev->get()[0]->id : 0);
        $product_parent_id = ($product->count() > 0 ? $product_rev->get()[0]->parent_id : 0);
        $img_gal = ProductImages::where('product_id', $product_id)->get();
		$prod_rev_row = ProductReviewsandRating::where('user_id',$uid)->where('product_id',$product_id);
		$prod_rev = $prod_rev_row->get();
		$prod_rev_count = $prod_rev_row->count();
		$paginate_count = (!empty($uid)) ? 6 : 3;
		$prod_rev_list = ProductReviewsandRating::where('product_id',$product_id)->with('UserProfileData')->paginate($paginate_count);
        $user_type = (Auth::user()) ? Auth::user()['users_type_id'] : [];
        $userBrands = UserBrands::where('user_id',$uid)->pluck('brand_id')->all();
        if(!empty($user_type)) {
            $user_product_price = ProductUserPrice::where('product_id', $product_id)->where('user_types_id',$user_type)->first()['price'];
            $user_product_discount_type = ProductUserPrice::where('product_id', $product_id)->where('user_types_id',$user_type)->first()['discount_type'];
        } else {
            $user_product_price  = 0;
            $user_product_discount_type = 0;
        }
        $user_condition = UserBrands::where('user_id', $uid)->where('brand_id', Product::with('BrandData')->findOrFail($product_id)->BrandData['id'])->get()->isEmpty();
        $query = ProductReviewsandRating::where('product_id', $product_id)->count();
        //dd($product[0]->ProductCategoryData[rand(0,(count($product[0]->ProductCategoryData) - 1))]['SameCategoryProduct']);
        $productAttributes = $product[0]->UsedAttribute;
        $category='';        
        if($product[0]->interior == 1) {
            $category = 'interior';
        }
        if($product[0]->exterior == 1 ) {
            $category .=  '  exterior';
        }

        if($product[0]->industrial == 1) {
            $category = 'Industrial';
        }

        if($product[0]->surface_preparation == 1 ) {
            $category .=  'Surface Preparation';
        }
        $sub_category = array();
        foreach($product as $item ){                
            if(!empty($item->ProductCategoryData)) {
                foreach($item->ProductCategoryData as $item) {                        
                    $sub_cat = Category::where('id','=',$item->category_id)->get();
                    array_push($sub_category,$sub_cat[0]->name);
                }
            }
        }

        $subproduct 	= Product::where('parent_id',$product_id)
        ->with('ProductVariableData')
        ->with('ProductAttributeData')
        ->with('ProductUserPrice')->get(); 

        if($request->color_swatches) {
            $prod_attrib = array(
                'parent_id' => isset($request->parent_id) ? $request->parent_id : $product_parent_id,
                'product_name' => $request->prod_name,
            );            

            $cart = $request->session()->get('cart');     
            $preselected_colors = $request->session()->get('preselected-colors');    
            return view('user.product.details', compact('uid','category', 'cart','preselected_colors', 'sub_category','cart', 'prod_attrib', 'user_product_price','user_product_discount_type','product_id','product','img_gal','query','user_condition','prod_rev_list', 'slug_name','prod_rev','user_type','product_rev','highprice','minsaleprice','prod_rev_list','userBrands'));
        }
        $color_count = $product[0]->UsedAttribute->count();
        if($color_count >5 )
        {
            return view('user.color-swatches.index',compact('product_id','productAttributes'));
        }else{                          
            return view('user.product.details', compact('uid','category','cart','sub_category','user_product_price','user_product_discount_type','product_id','product','img_gal','query','user_condition','prod_rev_list', 'slug_name','prod_rev','user_type','product_rev','highprice','minsaleprice','prod_rev_list','userBrands'));
        }           
    }

    public function removeFilters(Request $request, $type, $filter, $name){
        $request->session()->forget('myfilter.'.$filter.'.'.$name);

        return redirect('products/search#prodlist');
    }
    
    public function putFilters(Request $request, $type, $filter, $name){
    	$check_exist =  $request->session()->get('myfilter.'.$filter);
		$needle = $filter.": ".str_replace(',','-',$name);
        //removing filter to session
        if (in_array($filter, array("price","rating","category",'brand'))) {
        	if($filter == 'price'){
        		 $request->session()->forget('myfilter.'.$filter);
        	}else{
        		// check if brand child filter exist then remove if yes
        		$trigrem = true;
				if($check_exist){
					$trigrem = false;
					if(!empty(in_array($needle, $check_exist))){
						$mykey = array_search($needle, $check_exist);
						$request->session()->forget('myfilter.'.$filter.'.'.$mykey);
					}
				}
        	}
          
        }
		$trig = ($check_exist) ? (empty(in_array($needle, $check_exist)) ? true : false) : true;

		if($trig == true){
			$request->session()->push('myfilter.'.$filter, ($filter.": ".str_replace(',','-',$name)));
		}
		return redirect('products/search#prodlist');
    }

    public function clearAllFilters(Request $request,$type, $sess_name){
        $request->session()->forget($sess_name);
        if($type == "p"){
            return redirect('products#prodlist');
        }else{
            return redirect('products/search#prodlist');
        }
    }

    public function search(Request $request)
    {
        $myfilter = array();
        $sort = "";
        $search = "";
        $getCategory = "";
        $myfilter = $request->session()->get('myfilter');

        $getFiltered = array();
        $brandfltr = array();
        $getAttrs = array();
        $getBrandwhere = array();
		$getCatwhere = array();
        $pricefltr = array();
        $ratingfltr = array();
        $catfltr = array();
        $getProdSql = array();
        $getProdSale = array();

        //brand Product
        $uBp = array();

        $search = trim($request->s);
        $search_explode = explode(' ',$request->s);
        $sort = $request->sort;
        $sortFlt = explode('-', $request->sort);
        $sortFlt = array_filter($sortFlt);
        $getProductwhere = array();
        $getProdSale = 1;

        if(!empty($sortFlt[0]) && !empty($sortFlt[1])){
            $fieldName = $sortFlt[0];
            $orderby = $sortFlt[1];
        }else{
            $fieldName = 'created_at';
            $orderby = 'desc';
        }
        $variables = Variable::with('AttributeData')->get(); // Color Filter
        $uid = Auth::id();
        $userBrands = UserBrands::where('user_id',$uid)->pluck('brand_id')->all();
        $userAllBrands = Brand::where('hide_brand',0)->pluck('id')->all();
        $userBran = Brand::get();
        $getBrand = Product::with('BrandData')->where('parent_id', 0)->groupBy('brand_id')->get();
        if (@count(array_filter($myfilter)) > 0) {
 			$undefined = true;
            foreach ($myfilter as $filters) {
                foreach ($filters as $val) {
                    $exp = explode(': ', $val);
                    if ($exp[0] != "brand" && $exp[0] != "price" && $exp[0] != "rating" && $exp[0] != 'category' && $exp[0] != 'undefined') {
                        $getFiltered[] = $exp[1];
                    }
                    if ($exp[0] == "brand") {
                        $brandfltr[] = $exp[1];
                    }
                    if ($exp[0] == "price") {
                        $pricefltr[] =  $exp[1];
                    }
                    if ($exp[0] == "rating") {
                        $ratingfltr[] =  $exp[1];
                    }
					if ($exp[0] == "category") {
                        $catfltr[] =  $exp[1];
                    }
                	
                }
            }
            //For Brands Filter
            for ($b = 0; $b < count($brandfltr); $b++) {
                $brands = $brandfltr[$b];
                $prodAttr = Product::whereHas('BrandData', function ($q) use ($brands) {
                    $q->where('slug_name',$brands);
                })->first();
                $getBrandwhere[] = $prodAttr->brand_id;
                $getProductwhere[] = $prodAttr->id;
            }

            //For Variables with Attributes Filter
            for ($f = 0; $f < count($getFiltered); $f++) {
                $productsAttr = Attribute::with('ProductAttributeData')->where('name', $getFiltered[$f])->first();
                if (isset($productsAttr->ProductAttributeData)) {
                    foreach ($productsAttr->ProductAttributeData as $prodAttrs) {
                        $getParent = Product::where('id', $prodAttrs->product_id)->first();
                        $getAttrs[] = $getParent->parent_id;
                    }
                }
            }
			//for Category
			for ($c = 0; $c < count($catfltr); $c++) {
                $cat_slug = $catfltr[$c];
				$catlist = Category::where('slug_name',$cat_slug)->first();
            	//dd($catlist);
				$catid = $catlist->id;
                $prodCat = Product::with(['ProductCategoryData'=>function($q) use($catid){
                	$q->where('category_id',$catid);
                }])->first();
				
                $getCatwhere[] = $catid;
                $getProductwhere[] = $prodCat->id;
            }

        }else{
            $prodAttr = Product::with('BrandData')->get();
            foreach($prodAttr as $prodAttrRow){
                $getBrandwhere[] = $prodAttrRow->brand_id;
                $getProductwhere[] = $prodAttrRow->id;
            }
        }
        $getCategory = Category::whereHas('ProdCatData', function($q) use($getProductwhere){
            $q->whereHas('CatData', function($qq) use($getProductwhere){
               // $qq->whereIn('product_id', $getProductwhere);
            });
        })->get();
        foreach($getBrandwhere as $itemBrand){
            if(in_array($itemBrand, $userAllBrands)){
                array_push($uBp, $itemBrand);
            }
        }
        $products = Product::where(function($q) use($search_explode,$search,$getAttrs,$getBrandwhere,$pricefltr,$getFiltered,$ratingfltr,$uBp){
            $q->where('parent_id',0);
            if($search == 'sale' || $search == 'Sale'){
                $q->where('is_sale', 'LIKE', '%' . 1 . '%');
            }

            if($search != 'sale'){
                foreach($search_explode as $list){
                    $q->where('slug_name', 'LIKE', '%' . $list . '%');
                }
            }

            if (count($getFiltered) > 0) {
                $q->whereIn('id', $getAttrs);
            }

            if (count($uBp) > 0) {
                $q->whereIn('brand_id', $uBp);
            }

            if(count($pricefltr) > 0){
                foreach($pricefltr as $priceVal){
                    $exprice = explode('-',$priceVal);
                    $q->where('price', '>=', $exprice[0]);
                    $q->where('price', '<=', $exprice[1]);
                }
            }

            if (count($ratingfltr) > 0) {
                foreach ($ratingfltr as $rateVal) {
                    // $exrate = explode('-', $rateVal);
                   /* $q->where('rating', '>=', $exrate[0]);
                    $q->where('rating', '<=', $exrate[1]);*/
					//$q->where('rating', '>=', $exrate[0]);
					$q->where('rating', '=', $rateVal);
                }
            }

        })->with('BrandData')->whereHas('BrandData',function($pb) use($userBrands) {
            if(count($userBrands) > 0) {
                $pb->where('id', '<>', '');
                $pb->whereIn('brand.id', $userBrands);
            }
        })
		->with('ProductCategoryData')
		->whereHas('ProductCategoryData',function($pc) use($getCatwhere) {
			if (count($getCatwhere) > 0) {
			 	$pc->where('id','<>', '');
	    		$pc->whereIn('product_category.category_id', $getCatwhere);
			}
		})->orderBy($fieldName, $orderby);

        $allProducts = $products->get();
        $products = $products->paginate(12);
		$uid = Auth::id();
        $productsRangePrice = Product::where('name', 'LIKE', '%' . $search . '%')->where('parent_id', 0)->max('price');
        $products->appends(['sort'=>$sort,'s'=>$search])->fragment('prodlist')->render();
        return view('user.product.index')->with(array(
                    'countProducts' => $allProducts,
                    'products' => $products,
                    'search' => $search,
                    'sort' => $sort,
                    'myfilter' => !empty($myfilter) ? array_filter($myfilter) : $myfilter,
                    'type' => 'ps',
        			'userBrands' => $userBrands,
                    'brands' => $getBrand,
                    'variables' => $variables,
                    'productsRangePrice' => ($productsRangePrice * 2),
                    'pricesRnge' => (!empty($pricefltr[0])?explode('-',$pricefltr[0]):''),
                    'page' => 'products',
                    'ratingRnge' => (isset($ratingfltr[0])? $ratingfltr[0]:''),
                    'getCategory' => $getCategory,
                    'uid'=>$uid,
                ));
    }


	public function productvariance(Request $request)
    {        
        
        $uid = Auth::id();              
        $product = Product::where('parent_id', $request->parent_id)
            ->with('ParentData')
            ->withCount(['ProductAttributeData' => function ($query) use($request){
                $used_attribute = explode(",",trim($request->attri, ','));
                $query->whereIn('product_attribute.attribute_id', $used_attribute);
            }])
            ->having('product_attribute_data_count', '=' , $request->varcount)          
            ->get();
            $userprice = ProductUserPrice::where('product_id', $product[0]['id'])->get();
        	$user_type_id = User::where('id', $uid)->first()['users_type_id'];
            $url =  url('/img/products/');            
        	$value = array(
            	"url" =>  $url,
            	"product_child" => $product,
            	"user_type_id" =>  $user_type_id,
            	"pricetype" => $userprice,
            );            
            
        echo json_encode($value);
        // print_r($product);
    }
    
	public function product_ratings(Request $request)
	{
    	
        $validator = Validator::make($request->all(), [
            'rev_is_anon' => 'accepted',
            'rev_tagline' => 'required',
            'rev_desc' => 'required',
        ]);
        $message = '';
        if($validator->fails()){
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
            return Redirect::back()->withErrors($validator->errors())->with(array('status'=>'error','msg'=>$message));   
        } else {

        $new_filename = '';
        $allowedfileExtension = ['JPG','PNG','JPEG','jpg','png','jpeg'];
        if($request->hasFile('review_image')) {
            $banner             = $request->file('review_image');
            $filename           = $banner->getClientOriginalName();
            $extension          = $banner->getClientOriginalExtension();
            $check              = in_array($extension,$allowedfileExtension);

            if ($check) {
                $new_filename   = time() . '-' . $filename;
                $post_path      = public_path('img/reviews');
                $request->file('review_image')->move($post_path, $new_filename);
            } else {
                $message = 'Invalid File Type';
            }
        }

		$rating_stars = $request->rating_stars;
    	$rev_tagline  = $request->rev_tagline;
    	$rev_desc 	  = $request->rev_desc;
        $prodslug 	  = $request->prodslug;
		$is_anon 	  = ($request->has('rev_is_anon') == true ? $request->rev_is_anon : '');
		$product = Product::where('parent_id',0)->where('slug_name',$prodslug);
	
		$product_id = ($product->count() > 0 ? $product->get()[0]->id : 0);
		$uid = Auth::id();
		//check if existing 
		$prr = ProductReviewsandRating::where('user_id',$uid)->where('product_id',$product_id);
        
        if($prr->count() == 0 ){

            $prr_new = new ProductReviewsandRating;
            $prr_new->user_id = $uid;
            $prr_new->product_id = $product_id;
            $prr_new->title = $rev_tagline;
            $prr_new->reviews = $rev_desc;
            $prr_new->rate = $rating_stars;
            $prr_new->review_image = $new_filename;
            $prr_new->is_anonymous = $is_anon;
            $prr_new->created_at = date('Y-m-d');

            if($prr_new->save()){
                $prr_ex = ProductReviewsandRating::where('product_id',$product_id);
                if($prr_ex->count() > 0){
                    $prr_ex_sum = $prr_ex->sum('rate');
                    $prr_ex_count = $prr_ex->count();
                    $prr_computed_rate = $prr_ex_sum/$prr_ex_count;
                    
                    //$prod = $product = Product::where('parent_id',0)->where('slug_name',$prodslug)->get();
                    $update_prod = $product->get()[0];
                    $update_prod->rating = $prr_computed_rate;
                    
                    if($update_prod->save()){
                        return Redirect::back()->with(array('status'=>'success','msg'=>$message));
                    }
                    
                }
            }
        }else{
            return Redirect::back()->with(array('status'=>'danger','msg'=>$message));
        }

        }
    }

	public function add_wishlist(Request $request)
	{	$referer_lnk = \URL::previous();
		if($user = Auth::user()) { 
	        $checkit = UserWishlist::where('product_id', $request->product_id)->where('user_id', Auth::id())->first(); 
	        if ($checkit) {
	            $delete =  UserWishlist::find($checkit->id)->delete();
	            $message = 'Product is successfuly removed from wishlist';
	        } else {
	            $validator = Validator::make($request->all(), [
	                'product_id'  => 'required',
	            ]);
	
	            $message = '';
	            if ($validator->fails()) {            
	                foreach ($validator->errors()->all() as $error) {
	                    $message .= $error."\r\n";
	                }
	            } else {
	                $wishlist = new UserWishlist;
	                $wishlist->user_id              = Auth::id();
	                $wishlist->product_id           = $request->product_id;
	                
	                $wishlist->save();
	                $message = 'Product is successfuly added to wishlist';
	            }
	        }
			
	      // $return_arr = array('msg'=>$message); 
		  Session::flash('msg', $message);
		   
        } else {
            $message = "Please Login first before adding to wishlist.";  
			//$return_arr = array('msg'=>$message,'modalshow'=>'show','status'=>'danger','addcart'=>''); 
			
			Session::flash('msg', $message);
			Session::flash('modalshow','show');
			Session::flash('status', 'danger');
			Session::flash('addcart', '');
        }
		
		echo json_encode($message);
		
	}
	public function productview(Request $request)
	{
		$request->session()->put('product_view', $request->prodview);
		echo json_encode(array('status'=>'success'));
	}

    /*
    Create Function for Prduct Category Fetching RMM
    */
    public function sub_category(Request $request)
    {                
        $searchCat = $request->category;
        /** Change to Dynamic once records are cleansed */
        $sub_cat_search = array(
            'Concrete and Cement Boards',
            'Metal and Steel',
            'Wood'
        );

        $return_sub_cat = array();
        
        $sub_cat = Category::where(function($q)use($sub_cat_search){
            $q->whereIn('name', $sub_cat_search);
        })->get();          

        if($sub_cat){                        
            foreach($sub_cat as $item)
            {
                $producCategory = ProductCategory::where(function($q)use($sub_cat, $item){
                    $q->where('category_id','=',$item->id);
                })->get()->lists('product_id')->toArray();    
                $return_sub_cat[$item->name] = array(
                    'slug_name' => $item->slug_name,
                    'product' => Product::where(function($q) use($producCategory, $searchCat){                    
                        $q->where($searchCat,'=',1);
                        $q->wherein('id',$producCategory);
                        $q->where('is_featured','=',1);                    
                    })->get()
                );                                
            }                            
        }                      
		$uid = Auth::id();
        return view('user.sub-category.index', compact('return_sub_cat','searchCat','uid'));
    }
    /*
    Create Function for Prduct Sub Category Fetching RMM
    */
    function sub_category_list(Request $request){
        $param_sub_category = $request->sub_category;
        $category = $request->category;

        /** Change to Dynamic once records are cleansed */
        $cat = Category::where(function($q)use($param_sub_category){            
            $q->where('slug_name','=', $param_sub_category);
        })->get();                          
        if($cat){
            
            $producCategory = ProductCategory::where(function($q)use($cat){                
                $q->where('category_id','=',$cat[0]->id);
            })->get()->lists('product_id')->toArray(); 
        }        

        $product = DB::table('product')
        ->select('product.id')
        ->where('parent_id','=',0)
        ->where($category,'=',1)
        ->wherein('product.id',$producCategory)
        ->get();
        $subproduct_data = collect($product)->map(function($x){ return (array) $x; })->toArray(); 
        $product = \App\Product::whereIn('id',$subproduct_data)
        ->with(['BrandData'=>function($query){
            $query->with('ProductByBrand');
        }])
        ->with(['UsedVariables'=>function($query){
            $query->with('VariableData');
        }])
        ->with(['UsedAttribute'=>function($query){
            $query->with('AttributeData');
        }])
        ->with('AttributesData')
        ->with(['ParentData'=>function($query){
            $query->with('BrandData');
        }])
        ->with(['ChildData' => function($q) {
            $q->with(['AttributesData' => function($q) {
                $q->with('VariableData');
            }]);
        }])
        ->with(['ProductCategoryData'=>function($query){            
            $query->with(['SameCategoryProduct'=>function($querytwo){
                $querytwo->with(['ProductDetails'=>function($querythree){
                    $querythree->where('parent_id',0);
                }]);
            }]);
        }])
        ->with('ProductOverview')
        ->with(['ProductWishlist'=>function($query){
            $query->where('user_id', Auth::id());
        }])
        ->get();   

        $uid = Auth::id();
 
        return view('user.sub-category.list', compact('uid','category','param_sub_category', 'product'));
    }


    public function color_swatches() 
    {
        $param = 'blue';
        
        $cat_blue = Attribute::where(function($q)use($param){            
            $q->where('cat_color','=', $param);
        })->get();                                    
     
        $param = 'ACCENTS';
        $cat_accents = Attribute::where(function($q)use($param){            
            $q->where('cat_color','=', $param);
        })->get();        
        
        $param = 'BROWN';
        $cat_brown = Attribute::where(function($q)use($param){            
            $q->where('cat_color','=', $param);
        })->get();        
        
        $param = 'Gray';
        $cat_gray = Attribute::where(function($q)use($param){            
            $q->where('cat_color','=', $param);
        })->get();        
        
        $param = 'Green';
        $cat_green = Attribute::where(function($q)use($param){            
            $q->where('cat_color','=', $param);
        })->get();        
        
        $param = 'Indigo';
        $cat_indigo = Attribute::where(function($q)use($param){            
            $q->where('cat_color','=', $param);
        })->get();    
           
        $params = ['OFF WHITES', 'White'];

        $cat_off_whites = Attribute::where(function($q)use($params){          
                $q->whereIn('cat_color', $params);
        })->get();
        
        $param = 'Orange';
        $cat_orange = Attribute::where(function($q)use($param){            
            $q->where('cat_color','=', $param);
        })->get();        
        
        $param = 'Red';
        $cat_red = Attribute::where(function($q)use($param){            
            $q->where('cat_color','=', $param);
        })->get();        
        
        $param = ['Violet','Purple'];
        $cat_violet = Attribute::where(function($q)use($param){            
            $q->whereIn('cat_color', $param);
        })->get();    
        
        $param = 'Yellow';
        $cat_yellow = Attribute::where(function($q)use($param){            
            $q->where('cat_color','=', $param);
        })->get();
       
        $param = '';
        $cat_regColors = Attribute::where(function($q)use($param){            
            $q->where('cat_color','=', $param);
        })->get();

        $cat_bestSelling = Attribute::where(function($q)use($param){
            $q->where('best_selling','=', 1);
        })->get();

        return view('user.color-swatches.index', compact(
        'cat_blue',
        'cat_accents',
        'cat_brown',
        'cat_gray',
        'cat_green',
        'cat_indigo',
        'cat_off_whites',
        'cat_orange',
        'cat_red',
        'cat_violet',
        'cat_yellow',
        'cat_regColors',
        'cat_bestSelling'
        ));
    }

    public function paintResultFromQueryString(Request $request)
    {
        $search_name = $request->paint;

        $result = Product::where(function ($q) use ($search_name) {
            $q->where('name', '=', $search_name);
        })->get();

        return json_encode(array('data' => $result));
    }

    public function paintSuggestion(Request $request)
    {
        $surfaceType = $request->surfaceType;
        $surfaceLocation = $request->surfaceLocation;
        $category = array(
            'WOOD' => '22',
            'METAL AND STEEL' => '21',
            'CONCRETE' => '20'
        );

        $producCategory = ProductCategory::where(function ($q) use ($category, $surfaceType) {
            $q->where('category_id', '=', $category[$surfaceType]);
        })->get()
          ->lists('product_id')
          ->toArray();

        $result = Product::where(function ($q) use ($producCategory, $surfaceLocation) {
            $q->where($surfaceLocation, '=', 1);
            $q->whereIn('id', $producCategory);
        })->get();

        return json_encode(array('data' => $result));
    }

    public function allProducts()
    {
        $category = array(
            'Concrete and Cement Boards',
            'Metal and Steel',
            'Wood'
        );

        $allProducts = array(
            'Interior',
            'Exterior',
            'Surface_Preparation',
            'Industrial'
        );

        $result = array();

        $productCategory = Category::where(function ($q) use ($category) {
            $q->whereIn('name', $category);
        })->get();

        foreach ($allProducts as $product) {
            foreach ($productCategory as $item) {
                $producCategory = ProductCategory::where(function ($q) use ($item) {
                    $q->where('category_id', '=', $item->id);
                })->get()
                  ->lists('product_id')
                  ->toArray();

                $response[trim($item->name)][$product] = array(
                    'slug_name' => $item->slug_name,
                    'product' => Product::where(function ($q) use ($producCategory, $product) {
                        $q->where($product, '=', 1)
                          ->wherein('id', $producCategory)
                          ->where('is_featured', '=', 1);
                    })->get(),
                    'sub_category' => trim($item->name)
                );
            }
        }
        return view('user.sub-category.all-product', compact('response','allProducts'));
    }

    public function preselectedColors(Request $request) {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'color_names' => 'required',
            'color_ids' => 'required',
        ]);
        $message = '';
        if($validator->fails()){
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
            return Redirect::back()->withErrors($validator->errors())->with(array('status'=>'error','msg'=>$message));   
        } else {
            $product = Product::find($request->product_id);

            $request->session()->forget('preselected-colors');
            $request->session()->push('preselected-colors', $request->all()); 
            return redirect('/product/'.$product->slug_name.'?color_swatches=true');
        }
    }

    public function fetch(Request $request){
    $query = $request->get('query');
    $attributes = ProductAttribute::where('attribute_id','=',intval($query))->with('proddata')->get();
    $result = '<option value>Select Product</option>';
    $has_data = false;
    $arr_checker = [];

    foreach($attributes as $attribute) {
        if( $attribute->proddata !== null) {
            $prod_id = $attribute->proddata->id;
            $parent_id = $attribute->proddata->parent_id;
            $product = Product::find($parent_id);
            $prod_name = (!empty($product->name)) ? $product->name : $product->product_code;
            if(!empty($prod_name) && !in_array($prod_name, $arr_checker)) {
                $result .= '<option value="'.$prod_id.'">'.$prod_name.' </option>'; 
                array_push($arr_checker, $prod_name);
                $has_data = true;
            }
        }
    }
    if($has_data) echo $result;
    else echo '<option value>No product Available</value>';
    }

    //GET
    public function getfetch(Request $request){
        $prodid = $request->get('query');
        //dd($prodid);
        $parentProduct = Product::where('id', $request->get('query'))->first()['price'];
        $index = $request;
        echo json_encode($parentProduct);
    }

    public function requestQuote(Request $request) {
        $cart = Session::get('gocart');
        return view('user.request-a-quote.index', compact('cart'));
    }

    public function quoteSent(Request $request)
    {
        //dd($request->all(),Session::get('requestqoute'));
        $cart = Session::get('gocart');
        $name = $request->name;
        $cnum = $request->cnum;
        $eadd = $request->eadd;

        $data = array(
            'cart' => $cart,
            'name' => $name,
        );

        $this->send_email($data,$name,$eadd);
        if (Mail::failures()) {
            echo json_encode("Error sending quote to your email. Please contact customer service.");
        } else {
            Session::forget('gocart');
            echo json_encode("Quote sent. Kindly check your email.");
        }
    }

    private function send_email($data,$customer_name, $customer_email) {
        Mail::send('user.request-quote',$data,function($message) use($customer_email) {
           $message->to($customer_email)->subject
              ('Universal Paint Quote Request');
           $message->from('sales@universalpaint.net','Universal Paint');
        });
    }

    public function orderSent(Request $request)
    {
        Session::get('cart');
        //dd($request->all(),Session::get('requestqoute'));
        $requestqoute = Session::get('cart');
        $name = $request->name;
        $cnum = $request->cnum;
        $eadd = $request->eadd;
        Mail::send('user.send-order', compact('name', 'cnum', 'requestqoute'), function ($message) use($eadd) {
            $message->sender($eadd);
            $message->to($eadd);
        });
        Mail::send('user.send-order', compact('name', 'cnum', 'requestqoute'), function ($message) use($eadd) {
            $message->sender($eadd);
            $message->to('daphne.itworkserv@gmail.com');
        });
    
        if (Mail::failures()) {
            print_r("asd"); exit();
        } else {
            Session::forget('cart');
            Session::forget('gocart');
        }
    }

    //product go to cart
    public function gotocart(Request $request)
    {
     
    }

    public function checkout(Request $request)
    {
        $sub_total = '300'; 
        $products = $request->product;
        //dd($products);
        $arrprod = array();
        Session::forget('cart');
        //$request->session()->push('cart',$products);
        foreach($products as $index){
            $arrprod[] = array(
                'colorvar' => $index["colorvar"],
                'productid'=>  $index["productid"],
                'productname' => $index["productname"],
                'productsize' => $index["productsize"],
                'volumeprice' => $index["volumeprice"],
            );
        }
        //dd($arrprod);
         $request->session()->push('cart', $arrprod);
        return redirect('/checkout');
        //return json_encode($sub_total);
    }

    public function checkoutView(Request $request)
    {
        return view('user.product.checkout');
    }

    public function getSubProductVariance(Request $request) {

        $validator = Validator::make($request->all(), [
            'prod_attr_id' => 'required',
        ]);
        $message = '';
        if($validator->fails()){
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
            echo json_encode(array('status'=>false,'msg'=>$message)); 
        } else {
            $prod_attr_id   = (int)$request->prod_attr_id;
            $prod_attr_data = ProductAttribute::where("id","=",$prod_attr_id)->first();
            $product_id     = $request->product_id;
            $parent_id      = Product::where('id',"=",$product_id)->pluck('parent_id')[0];
            $parent_id      = $parent_id == 0 ? $product_id : $parent_id;
            $variations     = [];
            $search_attrib  = $request->color_name;

            $search_subproduct = DB::table('product')
            ->select('product.id')
            ->join('product_attribute','product_attribute.product_id', '=','product.id')
            ->join('attribute','attribute.id', '=','product_attribute.attribute_id')
            ->where('product.parent_id',$parent_id)
            ->where(function($query) use($search_attrib) {
                    $query->orwhere('attribute.name', '=', $search_attrib);
            })->get();
            $subproduct_data = collect($search_subproduct)->map(function($x){ return (array) $x; })->toArray(); 
            $subproducts = Product::where('parent_id',$parent_id)
              ->whereIn('id',$subproduct_data)
                ->with('ProductVariableData')
                ->with('ProductAttributeData')
                ->with('ProductUserPrice')->get();

            foreach($subproducts as $subproduct) {
                $attributes = "";
                foreach($subproduct->ProductAttributeData as $variation) {
                    $attrib = Attribute::find($variation->attribute_id);

                    $attributes .= isset($attrib->name) && !empty($attrib->name) && $attrib->name !== $search_attrib  ? $attrib->name .' ' : '';
                }
                if(!empty($attributes)) {
                    array_push($variations, ["attrib_id" => $prod_attr_id, "product_id" => $subproduct->id, "liters" => $attributes]);
                }
            }

            echo json_encode($variations);
        }
    }

    public function getColorDetails(Request $request) {

        $validator = Validator::make($request->all(), [
            'color_name' => 'required',
        ]);
        $message = '';
        if($validator->fails()){
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
            echo json_encode(array('status'=>false,'msg'=>$message)); 
        } else {
            $attrs = Attribute::where('name', '=', $request->color_name)->first();
            echo json_encode($attrs);
        }
    }

    public function getSubProductDetails(Request $request) {

        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
        ]);
        $message = '';
        if($validator->fails()){
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
            echo json_encode(array('status'=>false,'msg'=>$message)); 
        } else {
            $prod = Product::where('id', '=', $request->product_id)->first();
            echo json_encode($prod);
        }
    }

    public function getProductAttrib(Request $request) {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'attrib_id' => 'required'
        ]);
        $message = '';
        if($validator->fails()){
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
            echo json_encode(array('status'=>false,'msg'=>$message)); 
        } else {

            $product_id = (int)$request->product_id;
            $attrib_id = (int)$request->attrib_id;
            $product_attrib = ProductAttribute::where('product_id','=',$product_id)->where('attribute_id','=',$attrib_id)->first();
            if(!empty($product_attrib) && $product_attrib !== null)  { echo json_encode($product_attrib); }
            else { echo json_encode(array("status" => false,"msg" => "Error! Cannot fetch product attributes")); }
        }
    }

    public function getColors(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
        ]);
        $message = '';
        if($validator->fails())
        {
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }

            return response()->json([
                'status'=>false,'msg'=>$message
            ]);
        } else 
        {
            $colors_data = [];
            $product_id  = $request->product_id;    
            $subproducts = Product::where('parent_id',$product_id)
            ->whereHas('AttributesData', function($q) {
                $q->whereHas('VariableData', function($q) {
                    $q->where('name','=','Color');
                }, '!=', '');
            },'!=','')
            ->with(['AttributesData' => function($q) {
                $q->whereHas('VariableData', function($q) {
                    $q->where('name','=','Color');
                }, '!=', '');
            }])
            ->limit(20)
            ->get(); 

            foreach($subproducts as $subproduct) {
                foreach($subproduct["AttributesData"] as $attrib) {
                    $colors_data[$attrib->name] = $attrib->name;
                } 
            } 
            
            $colors_data = array_unique($colors_data);

            return response()->json($colors_data);


        }

    }

    public function getFullColors(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
        ]);
        $message = '';
        if($validator->fails())
        {
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }

            return response()->json([
                'status'=>false,'msg'=>$message
            ]);
        } else 
        {
            $product_id  = $request->product_id;    
            $product = Product::where('id',$product_id)
            ->with(['UsedAttribute'=>function($query){
                $query->with('AttributeData');
            }])
            ->first();

            return response()->json($product->UsedAttribute);

        }

    }

    public function getColorCss(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'selected_color' => 'required'
        ]);
        $message = '';
        if($validator->fails())
        {
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }

            return response()->json([
                'status'=>false,'msg'=>$message
            ]);
        } else 
        {
            $product_id      = $request->product_id;    
            $selected_color  = $request->selected_color;
            $subproduct      = Product::where('parent_id',$product_id)
            ->whereHas('AttributesData', function($q) use($selected_color) {
                $q->where('name',$selected_color);
            }, '!=','' )
            ->with(['AttributesData' => function($q) {
               $q->whereHas('VariableData', function($q) {
                    $q->where('name','=','Color');
                }, '!=', '');
            }])
            ->first(); 

            return response()->json($subproduct);
        }
    }

    public function getLiters(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'product_id'     => 'required',
            'selected_color' => 'required',
        ]);
        $message = '';
        if($validator->fails())
        {
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }

            return response()->json([
                'status'=>false,'msg'=>$message
            ]);
        } else 
        {
            $liters_data    = [];
            $product_id     = $request->product_id;  
            $selected_color = $request->selected_color;
            $subproduct     = DB::table('product')
            ->select('product.id')
            ->join('product_attribute','product_attribute.product_id', '=','product.id')
            ->join('attribute','attribute.id', '=','product_attribute.attribute_id')
            ->where('product.parent_id',$product_id)
            ->where(function($query) use($selected_color) {
                    $query->orwhere('attribute.name', '=', $selected_color);
            })->get();
            $subproduct_data = collect($subproduct)->map(function($x){ return (array) $x; })->toArray(); 
            $subproducts = \App\Product::where('parent_id',$product_id)
            ->whereIn('id',$subproduct_data)
                ->with('ProductVariableData')
                ->with('ProductAttributeData')
                ->with('ProductUserPrice')->get();

            foreach($subproducts as $subproduct) {
                $attributes = "";
                $liters_data[$subproduct->id] = '';
                foreach($subproduct->ProductAttributeData as $variation) {
                    $attrib = \App\Attribute::find($variation->attribute_id);

                    $attributes .= isset($attrib->name) && !empty($attrib->name) && $attrib->name !== $selected_color  ? $attrib->name .' ' : '';
                }
                if(!empty($attributes)) {
                    $liters_data[$subproduct->id] .= $attributes.' ';
                }
            }
                          
            
            return response()->json($liters_data);
        }
    }

    public function getVariationDetails(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'product_id'     => 'required',
            'subproduct_id' => 'required',
        ]);
        $message = '';
        if($validator->fails())
        {
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }

            return response()->json([
                'status'=>false,'msg'=>$message
            ]);
        } else 
        {
            $product_id     = $request->product_id;  
            $subproduct_id  = $request->subproduct_id;
            $subproducts    = Product::where('id', $subproduct_id)
            ->where('parent_id',$product_id)
            ->first(); 
            return response()->json($subproducts);
        }

    }

    public function getLitersNoColors(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'product_id'     => 'required',
        ]);
        $message = '';
        if($validator->fails())
        {
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }

            return response()->json([
                'status'=>false,'msg'=>$message
            ]);
        } else {
            $product_id     = $request->product_id;  
            $subproducts    = Product::where('parent_id',$product_id)
            ->whereHas('AttributesData', function($q) {
                $q->where('name', '!=', '');
            }, '!=','' )
            ->with(['AttributesData' => function($q) {
                $q->with('VariableData');
            }])->get(); 
            
            return response()->json($subproducts);
        }
    }
}
