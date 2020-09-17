<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//Model
use App\Product;
use App\ProductCategory;
use App\ProductPhoto;
use App\User;
use App\Order;
use App\OrderUserInfo;
use App\OrderItem;

use Validator;

class UserPageController extends Controller
{

    /**
     * Display user's purchase items
     *
     * @param  \App\Http\Requests\PaginationRequest $request
     * @return \Response
     */
    public function index()
    {

    	// User Information
    	$product_categories = ProductCategory::all();
    	$Orderinfo = OrderUserInfo::where('email',Auth::user()->email)->get();
    	$OrderData = array();
    	if(!empty($Orderinfo[0]))
    	{
    		foreach($Orderinfo as $info)
    		{
    			$OrderData[$info->order_id] = Order::find($info->order_id);
    		}    		
    	}    	
    	return view('user.user.userinfo',compact('product_categories','OrderData'));
    }

    public function OrderDetails(Request $request)
    {
    	// List all orders
    	$OrderId = $request->orderID;

    	$myInFo = OrderItem::where('order_id',$OrderId)->get();

    	foreach($myInFo as $key => $info){
    		$myProductName = $info->productInfo['name'];
    		$myProductQty = $info->quantity;
    		$myProductPrice = $info->price;
    		$myproductTotal = $info->sub_total;
    		unset($myInFo[$key]);
    		$myInFo[$key] = (Object) array(
    										'ProductName' 	=> $myProductName,
    										'ProductQty' 	=> $myProductQty,
    										'ProductPrice' 	=> number_format($myProductPrice,2),
    										'ProductTotal' 	=> number_format($myproductTotal,2)
    									);
    	}

    	echo json_encode($myInFo);

    }

    public function SaveProfile(Request $request)
    {

    	$validator = Validator::make($request->all(), [
                'prof_name'       => 'required',                
                'prof_mobile'     => 'required',
                'prof_company'    => 'required',
                'prof_province'   => 'required',
                'prof_city'       => 'required',
                'prof_address'    => 'required',
                'prof_postalcode' => 'required',
            ]);

    	$rets = 'error';

		if($validator->fails())
		{
            $message = '';
            foreach($validator->errors()->all() as $error)
            {
                $message .= $error."\r\n";
            }            
        } 
        else 
        {

        	$user = User::find(Auth::user()->id);

            $user->name         = trim($request->prof_name);
            $user->phonenum     = trim($request->prof_mobile);
            $user->companyname  = trim($request->prof_company);
            $user->province     = trim($request->prof_province);
            $user->city         = trim($request->prof_city);
            $user->address      = trim($request->prof_address);
            $user->postalcode   = trim($request->prof_postalcode);
            $user->updated_at   = date('Y-m-d h:i:s');
            $user->save();

            //success on save
            $message = 'You have successfully updated your profile!';
            $rets = 'success';
        }

        return redirect()->action('User\UserPageController@index')->with(array('returndata'=>$rets,'msg'=>$message));

    }



}