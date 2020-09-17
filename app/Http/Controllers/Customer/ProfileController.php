<?php

namespace App\Http\Controllers\Customer;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

use Config;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

use App\User;
use App\UserProfile;
use App\UserAddress;
use App\UserTypes;
use App\UserImages;
use App\Images;
use App\Role;
use App\UserCreditCards;
use App\UserWishlist;

use App\ProductReviewsandRating;

use App\Order;
use App\OrderItem;
use App\OrderCheckoutDetails;
use App\Product;

class ProfileController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @param  \App\Http\Requests\PaginationRequest $request
     * @return \Response
     */
    public function index()
    {
    	$uid = Auth::id();
		$uprofile = UserProfile::where('user_id',$uid)->get();
		$useraddress = UserAddress::where('user_id', $uid)->where('is_billing',0)->where('is_billing',0)->get(); 
		$useraddress_billing = UserAddress::where('user_id', $uid)->where('is_billing',1)->get(); 
		$useraddress_shipping = UserAddress::where('user_id', $uid)->where('is_shipping',1)->get(); 
		
		$userreviewandreatings = ProductReviewsandRating::with('UserData')->with('ProductData')->where('user_id',$uid)->paginate(3);
		$uimage = UserImages::where('user_id',$uid)->with('ImageData')->get();
		$gender = \Config::get('constants.gender'); 
    	
    	return view('customer.profile',compact('uid', 'gender','uprofile','useraddress','useraddress_billing','useraddress_shipping','userreviewandreatings','uimage'));
    }
	
	public function manage_profile()
	{
		$uid = Auth::id();
		$uprofile = UserProfile::where('user_id',$uid)->get();
		$uimage = UserImages::where('user_id',$uid)->with('ImageData')->get();
    	$upro = User::where('id', $uid)->get();
		$gender = \Config::get('constants.gender');  
    	return view('customer.manage_profile',compact('uid','upro', 'gender','uprofile','uimage'));
	}
	
	public function manage_address()
	{
		$uid = Auth::id();
		//$id = Auth::user()->id;
		
        //if(!empty(Auth::user()->permission)){ 
            $userID = User::find($uid); 
            if (empty($userID)) {
                abort(404);
            }
			$gender = Config::get('constants.gender');
            $role_list = Role::lists('role_name', 'id');
			$userprofile = UserProfile::where('user_id', $uid)->get(); 
			$useraddress = UserAddress::where('user_id', $uid)->get(); 
			$utype_list = UserTypes::lists('name', 'id'); 
            return view('customer.manage_address', compact('userID', 'role_list','utype_list','gender','userprofile','useraddress','uid'));

       /* } else {
            return redirect('admin/signin');
        }*/
    //	return view('customer.manage_address',compact('uid'));
	}
	
	public function manage_creditcard()
	{
		$uid = Auth::id(); 
		$cclist = UserCreditCards::where('user_id',$uid)->get(); 
    	return view('customer.manage_creditcard',compact('uid','cclist'));
	}
	
	public function update_profile(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'fname'            => 'required',
		  	'lname'            => 'required',
		  	'bdate'            => 'required',
        ]);

        if($validator->fails()){
            $message = '';
            foreach($validator->errors()->all() as $error){
                $message .= $error."\r\n";
            }
        } else {
        	$uid = Auth::id();
      
			//check if existing in table user profile
		$uprofile = UserProfile::where('user_id',$uid)->with('UserData')->first();
			
			
			$uprofile->user_id = $uid; 
			$uprofile->first_name = $request->fname;
			$uprofile->last_name = $request->lname;
			$uprofile->birthdate = $request->bdate;
			//$uprofile->age
			$uprofile->gender = $request->gender_name;
			$uprofile->mobile_num = $request->mob_num;
			$uprofile->tel_num = $request->tel_num;
        	$uprofile->UserData()->update(['email' =>$request->email ]);
			if($uprofile->save()){
				
				$message = 'Succesfully Updated.';
				return redirect()->action('Customer\ProfileController@index')->with('success',$message);
				
			}
			
			
		} 
	}

	public function address_details(Request $request)
	{
		// $addr_name 		 = $request->addr_name;
		$addr_frst_name  = $request->addr_frst_name;
		$addr_lst_name	 = $request->addr_lst_name;
		$addr_bdate 	 = $request->addr_bdate;
		$addr_telnum 	 = $request->addr_telnum;
		$addr_mobnum  	 = $request->addr_mobnum;
		$addr_stname  	 = $request->addr_stname;
		$addr_brgy  	 = $request->addr_brgy;
		$addr_city  	 = $request->addr_city;
		$addr_prov       = $request->addr_prov;
		$addr_othrnotes  = $request->addr_othrnotes;
		$addr_billing    = $request->addr_billing;
		$addr_shipping   = $request->addr_shipping;
		$addr_shipping_area = $request->area_region;
		$uaddress_id  	 = $request->uaddress_id;
		$msg = 'error';
		$msg_text = 'error';
		$msg_class = 'danger';
	//	print_r($request->all()); exit();
		$user_address_info = new UserAddress;
		$user_address_info->created_at = date('Y-m-d'); 
		if(!empty($uaddress_id)){
			$user_address_q= UserAddress::where('id',$uaddress_id)->get();
			$user_address_info = $user_address_q[0];
			$user_address_info->updated_at = date('Y-m-d');
		}
		$uid = Auth::user()->id;
		$tag = 'notset'; 
		if(!empty($addr_billing) || !empty($addr_shipping)){ 
			if(!empty($addr_billing) && !empty($addr_shipping)){
				$tag = 'billing_and_shipping';
				$user_address_q= UserAddress::where('user_id',$uid)->where('is_billing',$addr_billing)->orWhere('is_shipping',$addr_shipping)->get();
			}else if(!empty($addr_billing) && empty($addr_shipping)){
				$tag = 'billing';
				$user_address_q= UserAddress::where('user_id',$uid)->where('is_billing',$addr_billing)->get();
			}else if(!empty($addr_shipping) && empty($addr_billing)){
				$tag = 'shipping';
				$user_address_q= UserAddress::where('user_id',$uid)->where('is_shipping',$addr_shipping)->get();
			}
		
			//print_r($user_address_q." b".$addr_billing." s".$addr_shipping." ".$tag);
			if($user_address_q->count() > 0){
				foreach($user_address_q as $uai){
					$user_address_update_existing = UserAddress::where('id',$uai->id)->get();
				
					$user_address_update_existing = $user_address_update_existing[0];
					if($tag == 'billing_and_shipping'){
						if($uai->id != $uaddress_id){
							$user_address_update_existing->is_shipping = 0;
							$user_address_update_existing->is_billing = 0;
						}
						
					//	print_r("ASDa");
					} 
					if($tag == 'billing'){ 
						$user_address_update_existing->is_billing = 0;
					}
					if($tag == 'shipping'){
						$user_address_update_existing->is_shipping = 0;
					}
					$user_address_update_existing->save();
				}
			}else{
				if(!empty($uaddress_id) || $uaddress_id != 0){
					$user_address_update_existing = UserAddress::where('id',$uaddress_id)->get();
					$user_address_update_existing = $user_address_update_existing[0];
					if($tag == 'billing_and_shipping'){
							$user_address_update_existing->is_shipping = 0;
							$user_address_update_existing->is_billing = 0;
							
						} 
					if($tag == 'billing'){
						$user_address_update_existing->is_billing = 0;
					}
					 if($tag == 'shipping'){
						$user_address_update_existing->is_shipping = 0;
					}
					$user_address_update_existing->save(); 
				}
			}
			
		}

		$user_address_info->user_id 		= $uid;
		// $user_address_info->fullname 		= $addr_name;
		$user_address_info->first_name 		= $addr_frst_name;
		$user_address_info->last_name 		= $addr_lst_name;
		$user_address_info->birthdate 		= $addr_bdate;
		$user_address_info->tel_num 		= $addr_telnum;
		
		
    	$user_address_info->area_region 	= $addr_shipping_area;
		$user_address_info->mobile_num 		= $addr_mobnum;
		$user_address_info->no_bldg_st_name = $addr_stname;
		$user_address_info->brgy 			= $addr_brgy;
		$user_address_info->city_municipality = $addr_city;
		$user_address_info->province 		= $addr_prov;
		$user_address_info->other_notes 	= $addr_othrnotes;
		$user_address_info->is_billing 		= (!empty($addr_billing) || $addr_billing != null) ? $addr_billing : 0;
		$user_address_info->is_shipping 	= (!empty($addr_shipping) || $addr_shipping != null) ? $addr_shipping : 0;
		//print_r($user_address_info); exit();
		if($user_address_info->save()){
			$msg = 'success';
			$msg_text = '<strong>Success! </strong>New Address Added.';
			$msg_class = 'success';
			if(!empty($uaddress_id)){
				$msg_text = '<strong>Success! </strong>Existing Address Updated.';
			}
		}
		
		$msg_text = '<div class="alert alert-'.$msg_class.' alert-dismissible" role="alert">
					  '.$msg_text.'
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>';			
		
		
		echo json_encode(array('msg_text'=>$msg_text));
	}
	protected function getRegExp($name = ""){
		return preg_replace('/[^a-zA-Z0-9-_.\']/', '-', time()."-".$name);
	}
	
	
	public function manage_password()
	{
		$uid = Auth::id();
		return view('customer.manage_password',compact('uid'));
	}
	public function update_password(Request $request){
		$uid = Auth::id();
		$uprofile = User::where('id',$uid);
		$uprofile = $uprofile->get()[0];

		$validator = Validator::make($request->all(), [
            'curr_pass'      	=> 'required',
		  	'new_pass'          => 'required|min:8|alpha_num',
		  	'cnfrm_new_pass'    => 'required_with:new_pass|same:new_pass|min:8',
        ], [
			'curr_pass.required' 	=> 'The Current Password field is required.',
			'new_pass.required' 	=> 'The New Password field is required.',
			'new_pass.min' 			=> 'The New Password must be at least 8 characters.',
			'cnfrm_new_pass.required_with'	=> 'The Confirm New Password field is required when New Password is present.',
			'cnfrm_new_pass.same' 			=> 'The Confirm New Password and New Password must match.',
			'cnfrm_new_pass.min' 			=> 'The Confirm New Password must be at least 8 characters.',
		]);
		if(!Hash::check($request->curr_pass, $uprofile->password)){
			return redirect()->back()->with('status','The specified password does not match the database password!')->with('myclass','danger');
		}else {
			if($validator->fails()){
			$message = '';
			foreach($validator->errors()->all() as $error){
				$message .= $error."\r\n";
			}
			return redirect()->back()->with('status', $message)->with('myclass','danger')->withInput()->withErrors($validator);
		} else {
			if(Hash::check($request->new_pass, $uprofile->password)){
				return redirect()->back()->with('status','Please use a new password!')->with('myclass','danger');
			}else{
				$uprofile->password   = bcrypt($request->new_pass);
				if($uprofile->save()){
					$message = 'Succesfully Updated.';
					return redirect()->action('Customer\ProfileController@index')->with(array('status'=>'Password successfully updated!','msg'=>$message));
				}
			}
			// write code to update password
		}
		} 
	}

	public function image_upl(Request $request)
	{
		//print_r($request->all()); exit();
		$message = "success";
		$uid = Auth::id();
    	$new_filename = '';
		$filename = '';
        $allowedfileExtension   =['JPG','PNG','JPEG','jpg','png','jpeg'];
        if($request->hasfile('profpic')) { 
        	
			//check if file exist or there is changes in upload 
			if(!file_exists(public_path('img/customer/profile').$request->profpic->getClientOriginalName())){
				$variation_upload_image   = $request->file('profpic');
				$filename           = $variation_upload_image->getClientOriginalName();
                $extension          = $variation_upload_image->getClientOriginalExtension();
                $check              = in_array($extension,$allowedfileExtension);

                if ($check) {
                    $new_filename   = $new_filename   =  time() . '-' . str_replace(' ', '-',$filename); 
                    $post_path      = public_path('img/customer/profile');	
                    $variation_upload_image->move($post_path, $new_filename);
                } else {
                    $message = 'Invalid File Type';
                }	
			}
			
			
			if(!empty($new_filename)){
					$uimage = UserImages::where('user_id',$uid);
					if($uimage->count() > 0){
						$image_id = $uimage->get()[0]->images_id;
						$images = Images::find($image_id);
						
						$images->delete();
						$uimage->delete();
					}
					
					$new_image = new Images;
					
					$new_image->original_name 	= $filename;
					$new_image->file_name 		= $new_filename;
					$new_image->created_at	= date('Y-m-d h:i:s');
					
					if($new_image->save()){
						$new_uimage = new UserImages;
						
						$new_uimage->images_id = $new_image->id;
						$new_uimage->user_id = $uid;
						$new_uimage->created_at	= date('Y-m-d h:i:s');
						$new_uimage->save();
						$message = 'Succesfully Updated.';
						return redirect()->action('Customer\ProfileController@index')->with(array('status'=>'success','msg'=>$message));
					}
				}else{
					$message = 'Succesfully Updated.';
					return redirect()->action('Customer\ProfileController@index')->with(array('status'=>'success','msg'=>$message));
				}
		}
	}

	public function update_ccdetails(Request $request){
		$validator = Validator::make($request->all(), [
            'cc_type'       => 'required',
		  	'cc_number'     => 'required',
		  	'cc_holder'     => 'required',
		  	'cc_exp_date'	=> 'required',
        ]);
		
		if($validator->fails()){
            $message = '';
            foreach($validator->errors()->all() as $error){
                $message .= $error."\r\n";
            }
        } else {
        	$uid = Auth::id();
      
			$cc_id = $request->cc_id;
			$cc_tbl = new UserCreditCards;
			if(!empty($cc_id)){
				$cc_tbl = UserCreditCards::find($cc_id);
			}
			$cc_tbl->user_id = $uid;
			$cc_tbl->type = $request->cc_type;
			$cc_tbl->number = $request->cc_number;
			$cc_tbl->holder = $request->cc_holder;
			$cc_tbl->expiry_date = date('Y-m', strtotime($request->cc_exp_date));
			
			
			if($cc_tbl->save()){
				$msg = 'success';
				$msg_text = '<strong>Success! </strong>New Credit Card Details Added.';
				$msg_class = 'success';
				if(!empty($cc_id)){
					$msg_text = '<strong>Success! </strong>Existing Credit Card Details Updated.';
				}
			}
			
			$msg_text = '<div class="alert alert-'.$msg_class.' alert-dismissible" role="alert">
						  '.$msg_text.'
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    <span aria-hidden="true">&times;</span>
						  </button>
						</div>';			
			
			
			echo json_encode(array('msg_text'=>$msg_text));
			
			
			
		} 
	}
	
	public function manage_wishlist()
	{
		$uid = Auth::id();
		$Wishlist = UserWishlist::where('user_id',$uid)->with('ParentData')->paginate(5);
    	return view('customer.wishlist',compact('uid', 'Wishlist'));
	}

	public function remove_wishlist(Request $request)
	{
		$delete =  UserWishlist::find($request->wishlist_id)->delete();
		$message = 'Product is successfuly removed from wishlist';
        return redirect()->back()->with('status', $message);
	}

	
	public function order_details($id)
	{
		$orderid = $id;
		$uid = Auth::id();
	
    	$order = Order::where('id',$orderid)->with('OrderCheckoutDetailsData')
					  ->with('OrderItemData')->where('customer_id',$uid)->get();
					  
					  
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
           // ->where('slug_name','=',$slug_name)
            ->where('parent_id','=',0)
            ->get();
			//print_r($order); exit();
		return view('customer.order_details',compact('uid', 'order','product'));				
		//echo json_encode($order->toArray());
	}
	
	public function update_status(Request $request)
	{
		$orderid = $request->orderid;
		$optsel = $request->optsel;
		$order = Order::find($orderid);
		$order->status = $optsel;
		
		
		$msg = 'there is an Error Occured';
		$status = 'error';
		if($order->save()){
			$msg = 'Successfully update the order with code '.$order->order_code;
			$status = 'success';
		}
		
		echo json_encode(array('msg'=>$msg,'status'=>$status));
		
	}
}
