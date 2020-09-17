<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Config;
use Mail;
use App\User;
use App\UserProfile;
use App\Role;
use App\Settings;
use App\UserAddress;
use App\UserTypes;
use App\ShippingGngRates; 
use Validator;
class RegisterController extends Controller
{
    public function index()
    {
        $uid = Auth::id();
    	$gender = Config::get('constants.gender');
        $gngShippingRates = ShippingGngRates::get();
    	return view('user.register.index',compact('gender', 'gngShippingRates', 'uid'));
    }
	
	public function register_customer(Request $request)
	{
		//print_r($request->all()); exit();
		$user = $request->emailadd;       
        $user = User::where('email', '=', $user)->first();

        $request->flashOnly(['name', 'emailadd']);
		$settings =  Settings::get();
        $message = 'Email Address already exists';

        if($user === null)
        {
			$messages = [
			    'agree_box.required' => 'Please check the agreement for Terms and Conditions, Privacy & Policy',
			];
            $validator = Validator::make($request->all(), [
            	'firstname'     => 'required',
                'lastname'      => 'required',
                'gender'	    => 'required',
                'birthdate'		=> 'required',
                'emailadd' 		=> 'required|email',
                'password' 		=> 'required|min:8',
                'confpassword' 	=> 'required_with:password|required_with:password|same:password',
                'agree_box'		=> 'required',
            ],$messages);

            if($validator->fails()){
                $message = '';
                foreach($validator->errors()->all() as $error){

                    $message .= $error."\r\n";
                }
            } else {
				
				//set default role and type in user for anonymous user
				$utype = UserTypes::where('name','regular')->first(); 
				$role = Role::where('role_name','customer')->first(); 
				$role_id = $role->id;
                $myuser = new User;

                $myuser->role_id        = $role_id;
				$myuser->users_type_id  = $utype->id;
                $myuser->customer_id    = 'EZD';
                $myuser->name           = trim($request->firstname.' '.$request->lastname);
                $myuser->email          = trim($request->emailadd);
               /* $myuser->phonenum       = trim($request->phonenum);.
			    * 0
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
                    $RoleCode = $this->codeGen($role_id,2);
                    $UserID = $this->codeGen($myuser->id, 2);
                    $CustomerCode = "EZD".$RoleCode.$UserID;

                    $user = User::find($myuser->id);
                    $user->customer_id = trim($CustomerCode);
                    if($user->save()){
                    	//setup Profile
                   /* 	
                    	[_token] => BEiI5rU4kINrno9i6cltopjr3PARUubRHfBDB5MN
    [firstname] => Test
    [lastname] => User
    [gender] => Male
    [birthdate] => 09/04/1996
    [emailadd] => testuser2@mailcatch.com
    [phone_number] => 564566
    [password] => password
    [confpassword] => password
    [agree_box] => */
                    	$datas = array([
                            'fullname' => $request->firstname.' '.$request->lastname,
                            'emailadd' => $request->emailadd,
                            'titlesubject' => 'New Account'

                        ]);
                    	$uprofile = new UserProfile;
						$uprofile->user_id = $myuser->id;
						$uprofile->first_name = $request->firstname;
						$uprofile->last_name = $request->lastname;
						$uprofile->birthdate = date('Y-m-d',strtotime($request->birthdate));
						$uprofile->gender = $request->gender;
						$uprofile->mobile_num = $request->phone_number;
						$uprofile->created_at = date('Y-m-d h:i:s');
						
						
						if($uprofile->save()){

                            $uaddress = new UserAddress;
                            $uaddress->user_id = $myuser->id;
                            $uaddress->first_name = ucfirst($request->firstname);
                            $uaddress->last_name = ucfirst($request->lastname);
                            $uaddress->birthdate = $request->birthdate;
                            $uaddress->mobile_num = $request->phone_number;
                        	$uaddress->area_region = $request->area_region;
                            $uaddress->no_bldg_st_name = $request->no_bldg_st_name;
                            $uaddress->brgy = ucfirst($request->brgy);
                            $uaddress->city_municipality = ucfirst($request->city_municipality);
                            $uaddress->province = ucfirst($request->province);
                            $uaddress->is_billing = 1;
                        	$uaddress->is_shipping = 1;

                            $uaddress->save();
						    Mail::send('user.onlineregister', compact('datas'), function ($message) use($datas, $settings) {
                            $message->sender($settings[0]['email_address']);
                            $message->to($datas[0]['emailadd'])->subject($datas[0]['titlesubject']);
                            $message->embed(public_path() . '/img/banner-email.png');
    
                            });
                        
                            if (Mail::failures()) {
                                print_r("asd"); exit();
                            }
                            
                            $message = 'Your account is successfully registered.';
                            return redirect('/')->withInput()->with('success', $message);


                        }
                    }
                }
             
            }            
        }

        //error on save
        
        return redirect()->back()->withInput()->with('error', $message);
	}

	private function codeGen($i, $f) {
        $C = str_repeat("0", $f);
        $len = strlen($i);
        $a = substr($C, 0, $f - $len);
        return $a . $i;
    }  
	
}


