<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use App\UserProfile;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    public function postAjaxLogin(){ 
        $postData = \Request::only('customerid','customerpaswd','rememberme'); 
		$referer_lnk = \URL::previous();
        $credential = [	
                'email'     => isset($postData['customerid']) ? $postData['customerid'] : "",
                'password'  => isset($postData['customerpaswd'])   ? $postData['customerpaswd']   : "",               
                    ];

        $rememberMe = isset($postData['rememberme']) ? true : false;
		
		$status = 'danger';  
        if(!empty($credential['email']) && !empty($credential['password'])){   // print_r(\Auth::attempt($credential, $rememberMe)); exit();
            if($result = \Auth::attempt($credential, $rememberMe)){ 
              // echo json_encode(array('action' => 'success', 'clientname'=>\Auth::user()->name));
              
			   /*$err_txt = 'Login';
			   $return_Arr = array('status'=>$status, 'msg'=>$err_txt);
			   return redirect($referer_lnk)->with($return_Arr);*/
			 
			   if(!empty(Auth::user()->role_id == '2')){
					//return redirect('customer/dashboard');
					
					$check_if_prof = UserProfile::where('user_id',Auth::id())->first();
					$display_name = (!empty($check_if_prof) ? $check_if_prof->first_name." ".$check_if_prof->last_name : Auth::user()->name);
					session(['display_name' => $display_name]);
					
					return redirect($referer_lnk)->with(array('modalshow'=>'show','msg'=>'Successfully Login','status'=>'success','pagecode'=>''));
				} else {
					\Session::flush();
					\Auth::logout();
					$return_Arr = array('status'=>'danger', 'msg'=>'These credentials is not allowed to access this site.','modalshow'=>'show','pagecode'=>'');
					return redirect($referer_lnk)->with($return_Arr);
				}
				
			} else {  
            	$err_txt = 'These credentials do not match our records.';
				$return_Arr = array('status'=>$status, 'msg'=>$err_txt,'modalshow'=>'show','pagecode'=>'');
			   return redirect($referer_lnk)->with($return_Arr);
            }
        } else {
            if(empty($credential['id']) && empty($credential['password'])){
              
				$err_txt = 'Customer ID and Password field are required';
				$return_Arr = array('status'=>$status, 'msg'=>$err_txt,'modalshow'=>'show','pagecode'=>'');
			    return redirect($referer_lnk)->with($return_Arr);
            } else if (empty($credential['id']) && !empty($credential['password'])){
				$err_txt = 'Customer ID is required';
				$return_Arr = array('status'=>$status, 'msg'=>$err_txt,'modalshow'=>'show','pagecode'=>'');
			    return redirect($referer_lnk)->with($return_Arr);
                
            } else if (!empty($credential['id']) && empty($credential['password'])){
            	$err_txt = 'Password field is required';
				$return_Arr = array('status'=>$status, 'msg'=>$err_txt,'modalshow'=>'show','pagecode'=>'');
			    return redirect($referer_lnk)->with($return_Arr);             
            }
        }


    }
	
	public function login_dashboard(){
		
	}
    public function postLogOut()
    {
        \Session::flush();
        \Auth::logout();
        return redirect('/');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
