<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	public function getSignIn()
    {
		if(!empty(Auth::user()->permission)){
			return redirect('admin/users');
		} else {			
			return view('admin.auth.signin', [
			]);
		}		
    }

    public function postSignIn()
    {
		
		$postData = \Request::only('emailadd','passwd','rememberme');
		
		$credential = [
				'email' 	=> isset($postData['emailadd']) ? $postData['emailadd'] : "",
				'password' 	=> isset($postData['passwd']) 	? $postData['passwd'] 	: "", 				
					];
		$rememberMe = isset($postData['rememberme']) ? true : false;
		
		if(!empty($credential['email']) && !empty($credential['password'])){
			if($result = \Auth::attempt($credential, $rememberMe)){
				if(!empty(Auth::user()->permission)){
					return redirect('admin/dashboard');
				} else {
					\Session::flush();
					\Auth::logout();
					return redirect('admin/signin')->with('status', 'These credentials is not allowed to access this site.');
				}
			} else {
				$error['userName'] = 'These credentials do not match our records.';
				return view('admin.auth.signin',$error);
			}
		} else {
			if(empty($credential['email']) && empty($credential['password'])){
				$error['userName'] = 'Username field is required';
				$error['passWord'] = 'Password field is required';
				return view('admin.auth.signin',$error);
			} else if (empty($credential['email']) && !empty($credential['password'])){
				$error['userName'] = 'Username field is required';
				return view('admin.auth.signin',$error);
			} else if (!empty($credential['email']) && empty($credential['password'])){
				$error['passWord'] = 'Password field is required';				
				return view('admin.auth.signin',$error);
			}
		}
				        
    }

    public function getSignOut()
    {
        \Session::flush();
		\Auth::logout();
		return redirect('/');
    }
}
