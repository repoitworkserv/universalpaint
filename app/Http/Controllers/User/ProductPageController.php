<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
    
    public function details($slug_name)
    { 
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
        $img_gal = ProductImages::where('product_id', $product_id)->get();
		$prod_rev_row = ProductReviewsandRating::where('user_id',$uid)->where('product_id',$product_id);
		$prod_rev = $prod_rev_row->get();
		$prod_rev_count = $prod_rev_row->count();
		$paginate_count = (!empty($uid)) ? 6 : 3;
		$prod_rev_list = ProductReviewsandRating::where('product_id',$product_id)->with('UserProfileData')->paginate($paginate_count);
        $user_type = Auth::user()['users_type_id'];
        $userBrands = UserBrands::where('user_id',$uid)->pluck('brand_id')->all();
        $user_product_price = ProductUserPrice::where('product_id', $product_id)->where('user_types_id',$user_type)->first()['price'];
        $user_product_discount_type = ProductUserPrice::where('product_id', $product_id)->where('user_types_id',$user_type)->first()['discount_type'];
        $user_condition = UserBrands::where('user_id', $uid)->where('brand_id', Product::with('BrandData')->findOrFail($product_id)->BrandData['id'])->get()->isEmpty();
        $query = ProductReviewsandRating::where('product_id', $product_id)->count();
        //dd($product[0]->ProductCategoryData[rand(0,(count($product[0]->ProductCategoryData) - 1))]['SameCategoryProduct']);
        return view('user.product.details', compact('uid','user_product_price','user_product_discount_type','product_id','product','img_gal','query','user_condition','prod_rev_list', 'slug_name','prod_rev','user_type','product_rev','highprice','minsaleprice','prod_rev_list','userBrands'));
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

    public function interior()
    {        
        $searchKey = '1';
        
        $interior_door;
        $interior_wall;
        $interior_floor;
        $interior_ceiling;
        $interior_furniture;
        $interior_automotive;

        //door
        $param = 'door';
        $cat = Category::where(function($q)use($param){            
            $q->where('name','=', $param);
        })->get();          

        if($cat){
            
            $producCategory = ProductCategory::where(function($q)use($cat){
                $q->where('category_id','=',$cat[0]->id);
            })->get()->lists('product_id')->toArray();        
            // $interior_door = Product::whereIn('id',$producCategory)->get();
            $interior_door = Product::where(function($q) use($producCategory){
                $q->where('interior','=',1);
                $q->wherein('id',$producCategory);

            })->get();
        }
        
        //wall
        $param = 'wall';        
        $cat = Category::where(function($q)use($param){            
            $q->where('name','=', $param);
        })->get();                
        if($cat){
            $producCategory = ProductCategory::where(function($q)use($cat){
                $q->where('category_id','=',$cat[0]->id);
            })->get()->lists('product_id')->toArray();

            $interior_wall = Product::where(function($q) use($producCategory){
                $q->where('interior','=',1);
                $q->wherein('id',$producCategory);

            })->get();
        }
        
        //floor
        $param = 'floor';
        $cat = Category::where(function($q)use($param){            
            $q->where('name','=', $param);
        })->get();  
                              
        if($cat){
            $producCategory = ProductCategory::where(function($q)use($cat){
                $q->where('category_id','=',$cat[0]->id);
            })->get()->lists('product_id')->toArray();

            $interior_floor = Product::where(function($q) use($producCategory){
                $q->where('interior','=',1);
                $q->wherein('id',$producCategory);

            })->get();
        }
        
        //ceiling
        $param = 'ceiling';
        $cat = Category::where(function($q)use($param){            
            $q->where('name','=', $param);
        })->get();                
        
        if($cat){
            $producCategory = ProductCategory::where(function($q)use($cat){
                $q->where('category_id','=',$cat[0]->id);
            })->get()->lists('product_id')->toArray();
    
            $interior_ceiling  = Product::where(function($q) use($producCategory){
                $q->where('interior','=',1);
                $q->wherein('id',$producCategory);
            })->get();
        }
        
        //furniture
        $param = 'furniture';
        $cat = Category::where(function($q)use($param){            
            $q->where('name','=', $param);
        })->get();                
        if($cat){
            $producCategory = ProductCategory::where(function($q)use($cat){
                $q->where('category_id','=',$cat[0]->id);
            })->get()->lists('product_id')->toArray();

            $interior_furniture = Product::where(function($q) use($producCategory){
                $q->where('interior','=',1);
                $q->wherein('id',$producCategory);

            })->get();
        }
        
        //automative
        $param = 'automotive';
        $cat = Category::where(function($q)use($param){            
            $q->where('name','=', $param);
        })->get();                
        
        if($cat != null){
            $producCategory = ProductCategory::where(function($q)use($cat){
                $q->where('category_id','=',$cat[0]->id);
            })->get()->lists('product_id')->toArray();

            $interior_automative = Product::where(function($q) use($producCategory){
                $q->where('interior','=',1);
                $q->wherein('id',$producCategory);

            })->get();
        }               

		$uid = Auth::id();
        return view('user.interior.index', compact('interior_door','interior_wall', 'interior_floor','interior_ceiling','interior_furniture','interior_automative','uid'));
    }

    public function exterior()
    {
        $searchKey = '1';
                        
        $exterior_door;
        $exterior_wall;
        $exterior_floor;
        $exterior_ceiling;
        $exterior_furniture;
        $exterior_automotive;
        $exterior_roof;

        //door
        $param = 'door';
        $cat = Category::where(function($q)use($param){            
            $q->where('name','=', $param);
        })->get();          

        if($cat){
            
            $producCategory = ProductCategory::where(function($q)use($cat){
                $q->where('category_id','=',$cat[0]->id);
            })->get()->lists('product_id')->toArray();                    
            $exterior_door = Product::where(function($q) use($producCategory){
                $q->where('exterior','=',1);
                $q->wherein('id',$producCategory);

            })->get();
        }
        
        //wall
        $param = 'wall';        
        $cat = Category::where(function($q)use($param){            
            $q->where('name','=', $param);
        })->get();                
        if($cat){
            $producCategory = ProductCategory::where(function($q)use($cat){
                $q->where('category_id','=',$cat[0]->id);
            })->get()->lists('product_id')->toArray();

            $exterior_wall = Product::where(function($q) use($producCategory){
                $q->where('exterior','=',1);
                $q->wherein('id',$producCategory);

            })->get();
        }
        
        //floor
        $param = 'floor';
        $cat = Category::where(function($q)use($param){            
            $q->where('name','=', $param);
        })->get();  
                              
        if($cat){
            $producCategory = ProductCategory::where(function($q)use($cat){
                $q->where('category_id','=',$cat[0]->id);
            })->get()->lists('product_id')->toArray();

            $exterior_floor = Product::where(function($q) use($producCategory){
                $q->where('exterior','=',1);
                $q->wherein('id',$producCategory);

            })->get();
        }
        
        //ceiling
        $param = 'ceiling';
        $cat = Category::where(function($q)use($param){            
            $q->where('name','=', $param);
        })->get();                
        
        if($cat){
            $producCategory = ProductCategory::where(function($q)use($cat){
                $q->where('category_id','=',$cat[0]->id);
            })->get()->lists('product_id')->toArray();
    
            $exterior_ceiling  = Product::where(function($q) use($producCategory){
                $q->where('exterior','=',1);
                $q->wherein('id',$producCategory);
            })->get();
        }
        
        //furniture
        $param = 'furniture';
        $cat = Category::where(function($q)use($param){            
            $q->where('name','=', $param);
        })->get();                
        if($cat){
            $producCategory = ProductCategory::where(function($q)use($cat){
                $q->where('category_id','=',$cat[0]->id);
            })->get()->lists('product_id')->toArray();

            $exterior_furniture = Product::where(function($q) use($producCategory){
                $q->where('exterior','=',1);
                $q->wherein('id',$producCategory);

            })->get();
        }
        
        //automative
        $param = 'automotive';
        $cat = Category::where(function($q)use($param){            
            $q->where('name','=', $param);
        })->get();                
        
        if($cat != null){
            $producCategory = ProductCategory::where(function($q)use($cat){
                $q->where('category_id','=',$cat[0]->id);
            })->get()->lists('product_id')->toArray();

            $exterior_automative = Product::where(function($q) use($producCategory){
                $q->where('exterior','=',1);
                $q->wherein('id',$producCategory);

            })->get();
        }         

        //roof
        $param = 'roof';
        $cat = Category::where(function($q)use($param){            
            $q->where('name','=', $param);
        })->get();                
        
        if($cat != null){
            $producCategory = ProductCategory::where(function($q)use($cat){
                $q->where('category_id','=',$cat[0]->id);
            })->get()->lists('product_id')->toArray();

            $exterior_roof = Product::where(function($q) use($producCategory){
                $q->where('exterior','=',1);
                $q->wherein('id',$producCategory);

            })->get();
        }         


		$uid = Auth::id();
        return view('user.exterior.index', compact('exterior_door','exterior_wall', 'exterior_floor','exterior_ceiling','exterior_furniture','exterior_automative','exterior_roof','uid'));        
    }

    public function industrial()
    {
        $searchKey = '1';
        
        $industrial_door = Product::where(function($q) use($searchKey){
        if($searchKey != ''){
                $q->where('industrial','=', $searchKey);
            }
        })->with(['ProductCategoryData'=>function($q) {            
            $q->where('category_id',5);// exterior Door
        }])->orderBy('id')
        ->get();
        
        $industrial_wall = Product::where(function($q) use($searchKey){
            if($searchKey != ''){
                    $q->where('industrial','=', $searchKey);
                }
            })->with(['ProductCategoryData'=>function($q) {            
                $q->where('category_id',5);// exterior Door
            }])->orderBy('id')
            ->get();

		$uid = Auth::id();
        return view('user.industrial.index', compact('industrial_door','industrial_wall','uid'));
    }
    public function surfacePreparation()
    {
        $searchKey = '1';
        
        $surface_preparation_door = Product::where(function($q) use($searchKey){
        if($searchKey != ''){
                $q->where('surface_preparation','=', $searchKey);
            }
        })->with(['ProductCategoryData'=>function($q) {            
            $q->where('category_id',5);// exterior Door
        }])->orderBy('id')
        ->get();

        $surface_preparation_wall = Product::where(function($q) use($searchKey){
            if($searchKey != ''){
                    $q->where('surface_preparation','=', $searchKey);
                }
            })->with(['ProductCategoryData'=>function($q) {            
                $q->where('category_id',5);// exterior Door
            }])->orderBy('id')
            ->get();
        
		$uid = Auth::id();
        return view('user.surface-preparation.index', compact('surface_preparation_door','surface_preparation_wall','uid'));
    }
}
