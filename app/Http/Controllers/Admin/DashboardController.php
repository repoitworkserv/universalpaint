<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use Validator;
use DB;
use Config;
use Auth;

use App\Product;
use App\User;
use App\Order;

use App\UserImages;

class DashboardController extends Controller
{
    public function index()
    {
    	$id = Auth::id();
    	$product = Product::where('parent_id','0')->get();
		$customer = User::where('role_id','2')->get();
		
		$pending = Order::where('status','pending')->get();
		$process = Order::where('status','on_process')->get();
		$complete = Order::where('status','complete')->get();
        $total_order = Order::where('status','<>','cancel')->get();
        $uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
        return view('admin.dashboard.index',compact('uimage','product','customer','pending','process','complete','total_order'));
    }

    public function store(Request $request)
    {

    }

    public function update(Request $request)
    {

    }

    public function destroy($id)
    {
        
    }
}
