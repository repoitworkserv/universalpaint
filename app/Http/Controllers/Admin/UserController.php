<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
//Model
use Config;
use App\User;
use App\UserProfile;
use App\UserAddress;
use App\UserBrands;
use App\Role;
use App\UserTypes;
use App\Brand;
use Validator;
use App\UserImages;
use App\Images;

class UserController extends Controller
{

    /**
     * Display a list of User
     *
     * @param  \App\Http\Requests\PaginationRequest $request
     * @return \Response
     */
    public function index()
    {        
		$id = Auth::id();
        if(!empty(Auth::user()->permission)){
            $userlist = User::where('id','<>',1)->paginate(10);  
			$role_list = Role::lists('role_name', 'id');
			$utype_list = UserTypes::lists('name', 'id');
			$uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
            return view('admin.user.index', compact('uimage','userlist', 'role_list','utype_list'));
        } else {
            return redirect('admin/signin');
        }

    }

    /**
     * Show form for creating a new user.
     *
     * @return \Response
     */
    public function create()
    {
		$id = Auth::id();
        if(!empty(Auth::user()->permission)){
			$uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
            $role_list = Role::lists('role_name', 'id');
			$utype_list = UserTypes::lists('name', 'id');
			$brandlist 	    = Brand::get();			
            return view('admin.user.create', compact('uimage	', 'role_list','utype_list','brandlist'));
        } else {
            return redirect('admin/signin');
        }

    }
	
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\ProductRequest $request
     * @return \Response
     */
    public function store(Request $request)
    {
        

        $user = $request->emailadd;       
        $user = User::where('email', '=', $user)->first();

        $request->flashOnly(['name', 'emailadd']);

        $message = 'Email Address already exists';

        if($user === null)
        {

            $validator = Validator::make($request->all(), [
                'name'        	=> 'required',
                'emailadd' 		=> 'required|email',
                'password' 		=> 'required|min:8',
                'confpassword' 	=> 'required_with:password|same:password|min:8',
                'role_id' 		=> 'required',
                'usertypes_id' 	=> 'required',
            ]);

            if($validator->fails()){
                $message = '';
                foreach($validator->errors()->all() as $error){

                    $message .= $error."\r\n";
                }
            } else {

                $myuser = new User;

                $myuser->role_id        = $request->role_id;
				$myuser->users_type_id  = $request->usertypes_id;
                $myuser->customer_id    = 'EZD'.
                $myuser->name           = trim($request->name);
                $myuser->email          = trim($request->emailadd);
               /* $myuser->phonenum       = trim($request->phonenum);
                $myuser->companyname    = trim($request->companyname);
                $myuser->province       = trim($request->province);
                $myuser->city           = trim($request->city);
                $myuser->address        = trim($request->address);
                $myuser->postalcode     = trim($request->postalcode);*/
                $myuser->password   = bcrypt($request->password);
                $myuser->created_at = date('Y-m-d h:i:s');
              //  print_r( bcrypt($request->password)); exit();
                if($myuser->save()){                    
                    //success on save
                    $RoleCode = $this->codeGen($request->role_id,2);
                    $UserID = $this->codeGen($myuser->id, 2);
                    $CustomerCode = "EZD".$RoleCode.$UserID;

                    $user = User::find($myuser->id);
                    $user->customer_id = trim($CustomerCode);
                    if($user->save()){
                    	//setup Profile
                    	$uprofile = new UserProfile;
						$uprofile->user_id = $myuser->id;
						$uprofile->save();
						//setup brands
                    	$brands = $request->user_brandlist;
                    	if(count($brands) > 0){
                    		for($x=0;$x<count($brands); $x++){
                    			$ubrands = new UserBrands;
								$ubrands->brand_id = $brands[$x];
								$ubrands->user_id = $myuser->id;
								$ubrands->save(); 
                    		}
                    	}
						
                        $message = 'User '.$request->name.' has been added!';
                        return redirect()->action('Admin\UserController@index')->with('status', $message);
                    }
                }
             
            }            
        }

        //error on save
        
        return redirect()->back()->with('status', $message);

    }

    /**
     * Edit the product in the specified resource in storage.
     *
     * @param  int $id
     * @return \Response
     */
    public function edit($id)
    { 
        if(!empty(Auth::user()->permission)){  
            $userID = User::find($id); 
            if (empty($userID)) {
                abort(404);
            }

            $role_list = Role::lists('role_name', 'id');
			$utype_list = UserTypes::lists('name', 'id'); 
			$brandlist 	    = Brand::get();	
			$exlist = UserBrands::where('user_id',$id)->pluck('brand_id')->toArray();
			/*$exlist = UserBrands::where('user_id',$id);
			print_r($exlist->get()->toArray()); exit();*/
			$id = Auth::id();
			$uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
            return view('admin.user.edit', compact('uimage','userID', 'role_list','utype_list','brandlist','exlist'));

        } else {
            return redirect('admin/signin');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param  \App\Http\Requests\Admin\UpdateRequest
     * @return \Response
     */
    public function update(Request $request, $id)
    {


        $passwd     = $request->input('password');
        $confpasswd = $request->input('confpassword');

        $message = 'User Edit failed to save!';
        $arr_validator = array('role_id'       => 'required',
				                'usertypes_id' 	=> 'required',
				                'name'          => 'required',
				                'emailadd'      => 'required|email', );
		if(!empty($passwd) && !empty($confpasswd)){
			$arr_merger = array(
							'password'      => 'required|min:8',
                			'confpassword'  => 'required_with:password|same:password|min:8', 
							);
			$arr_validator = array_merge($arr_validator,$arr_merger);
		}
		$validator = Validator::make($request->all(), $arr_validator);
		if($validator->fails()){
            $message = '';
            foreach($validator->errors()->all() as $error){

                $message .= $error."\r\n";
            }
        } else {

            $user = User::find($id);
			
			if($user->role_id == 0 && $user->users_type_id == 0){
				$RoleCode = $this->codeGen($request->role_id,2);
                $UserID = $this->codeGen($user->id, 2);
                $CustomerCode = "EZD".$RoleCode.$UserID;
                $user->customer_id = trim($CustomerCode);
			}

            $user->role_id      = trim($request->role_id);
			$user->users_type_id  = $request->usertypes_id;
            $user->name         = trim($request->name);
			//$user->mobnum         = trim($request->mobnum);
            $user->email        = trim($request->emailadd);
            $user->updated_at   = date('Y-m-d h:i:s');
			
			
            if(!empty($passwd) && !empty($confpasswd)){
                $user->password   = bcrypt($request->password);
            }            

            if($user->save()){
            	
				 
				
            	$brands = $request->user_brandlist;
            	if(!empty($brands)){
            		for($x=0;$x<count($brands); $x++){
            			//filter existing record then delete if not found  checking if not exist in new record
            			$exlist = UserBrands::where('user_id',$id);
						if($exlist->count() > 0){
							foreach($exlist->get() as $el){
								if(!in_array($el->brand_id, $brands)){
									UserBrands::find($el->id)->delete();
								}
							}
						} 				
						//recheck if exist
            			$w_q = array('brand_id'=>$brands[$x], 'user_id'=>$id);
            			//$q = UserBrands::where('brand_id',$brands[$x]);
            			$q = UserBrands::where($w_q);
            			if($q->count() == 0){
            				$ubrands = new UserBrands;
							$ubrands->brand_id = $brands[$x];
							$ubrands->user_id = $id;
							$ubrands->save(); 
            			}
					}
            	}
				
				
				
				
                //success on save
                $message = 'User '.$request->name.' has been successfully updated!';
                return redirect()->action('Admin\UserController@index')->with('status', $message);
            }

        }

        //error on save        
        return redirect()->back()->with('status', $message);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Response
     */
    public function destroy($id)
    {
        $delete =  User::find($id)->delete();
        $message = 'User successfully deleted!';
        return redirect()->back()->with('status', $message);
    }

    private function codeGen($i, $f) {
        $C = str_repeat("0", $f);
        $len = strlen($i);
        $a = substr($C, 0, $f - $len);
        return $a . $i;
    }    
	
	public function profile()
    {
    	$id = Auth::user()->id;
        if(!empty(Auth::user()->permission)){ 
            $userID = User::find($id); 
            if (empty($userID)) {
                abort(404);
            }
			$gender = Config::get('constants.gender');
            $role_list = Role::lists('role_name', 'id');
			$userprofile = UserProfile::where('user_id', $id)->get();
			$useraddress = UserAddress::where('user_id', $id)->get(); 
			$utype_list = UserTypes::lists('name', 'id'); 
			$uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
            return view('admin.user.edit_profile', compact('uimage','userID', 'role_list','utype_list','gender','userprofile','useraddress'));

        } else {
            return redirect('admin/signin');
        }
	}

	protected function getRegExp($name = ""){
		return preg_replace('/[^a-zA-Z0-9-_.\']/', '-', time()."-".$name);
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
                    $new_filename   = $this->getRegExp($filename); 
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
						return redirect()->action('Admin\UserController@profile')->with(array('status'=>'success','msg'=>$message));
					}
				}else{
					$message = 'Succesfully Updated.';
					return redirect()->action('Admin\UserController@profile')->with(array('status'=>'success','msg'=>$message));
				}
		}
	}
	
	public function update_profile(Request $request,$id)
    {
		$message = 'User Edit failed to save!';
        $arr_validator = array('role_id'       => 'required',
				                'usertypes_id' 	=> 'required',
				                // 'name'          => 'required',
				                'first_name'          => 'required',
				                'last_name'          => 'required',
				                'emailadd'      => 'required|email', );
		if(!empty($passwd) && !empty($confpasswd)){
			$arr_merger = array(
							'password'      => 'required|min:8',
                			'confpassword'  => 'required_with:password|same:password|min:8', 
							);
			$arr_validator = array_merge($arr_validator,$arr_merger);
		}
		
		$validator = Validator::make($request->all(), $arr_validator);
		if($validator->fails()){
            $message = '';
            foreach($validator->errors()->all() as $error){

                $message .= $error."\r\n";
            }
        } else {

			$user = User::find($id);
            $user->role_id      = trim($request->role_id);
			$user->users_type_id  = $request->usertypes_id;
            $user->name         = trim($request->name);
            $user->email        = trim($request->emailadd);
            $user->updated_at   = date('Y-m-d h:i:s');

            if(!empty($passwd) && !empty($confpasswd)){
                $user->password   = bcrypt($request->password);
            }            

            if($user->save()){
                //success on save
                $uid = Auth::user()->id;
                $user_profile = UserProfile::where('user_id',$id)->get();
				if($user_profile->count() == 0){
					$user_profile = new UserProfile;
					$user_profile->created_at = date('Y-m-d');
				}else{
					$user_profile = $user_profile[0];
					$user_profile->updated_at = date('Y-m-d'); 
				}
				$user_profile->user_id = $uid;
				//$user->name         = trim($request->name);
		        $user_profile->first_name         = trim($request->first_name);
				$user_profile->last_name         = trim($request->last_name);
				$user_profile->mobile_num         = trim($request->mobnum);
				$user_profile->tel_num         = trim($request->tel_num);
				$user_profile->birthdate = $request->bdate;
				$user_profile->age = $request->age;
				$user_profile->gender = $request->gender;
				$user_profile->mobile_num = $request->mobnum;
				
				if($user_profile->save()){
					$message = 'User '.$request->name.' has been successfully updated!';
					$return = array('status'=>$message,'class_html' =>'success');
                	return redirect()->action('Admin\UserController@profile')->with($return);
				}
            }

        }
		$return = array('status'=>$message,'class_html' =>'danger');
        //error on save        
        return redirect()->back()->with($return);

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

}