<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator;
use DB;
use Config;
use Auth;
use Mail;

use App\Order;
use App\OrderItem;
use App\OrderCheckoutDetails; 
use App\Products;
use App\UserImages;
use App\OrderItemData;
use APP\User;
use App\UserAddress;
use App\Settings;
use App\EmailTemplate;


class OrderController extends Controller
{
    public function index(Request $request)
    {
		// print_r($_POST);
		// exit();	
		//$data = $request->session()->all();
		$uid = Auth::id();
		$search_item = ($request->search_item) ? $request->search_item : '';
		if(empty($search_item)) {
			$order = Order::with('OrderCheckoutDetailsData')
			->with(['OrderItemData'=>function($oitem) use($uid){
			  $oitem->where('seller_id','like', '%'.$uid.'%' );
			  }])->orderBy('created_at','desc')->paginate(10);
		}
		$uimage = UserImages::where('user_id',$uid)->with('ImageData')->get();
        return view('admin.orders.index',compact('uimage','order', 'search_item'));
	}
	
	public function search(Request $request)
	{
		$uid = Auth::id();
		$search_item = $request->search_item;
		if(empty($search_item)) {
			$order = Order::with('OrderCheckoutDetailsData')
			->with(['OrderItemData'=>function($oitem) use($uid){
			  $oitem->where('seller_id','like', '%'.$uid.'%' );
			  }])->orderBy('created_at','desc')->paginate(10);
		}
		else {
			$order = Order::where('status', 'like', '%'.$request->search_item.'%')
			->orWhere('order_code', 'like', '%'.$request->search_item.'%')
			->orWhere('payment_type', 'like', '%'.$request->search_item.'%')
			->orWhere('created_at', 'like', '%'.$request->search_item.'%')
			->with('OrderCheckoutDetailsData')
			->with(['OrderItemData'=>function($oitem) use($uid){
			  $oitem->where('seller_id','like', '%'.$uid.'%' );
			  }])->orderBy('created_at','desc')->paginate(10);
		}
		$uimage = UserImages::where('user_id',$uid)->with('ImageData')->get();
        return view('admin.orders.index',compact('uimage','order', 'search_item'));
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
	
	public function show(Request $request)
	{

	}
	
	public function order_details(Request $request)
	{
		$orderid = $request->orderid;
		$uid = Auth::id();
	
		$order = Order::where('id',$orderid)->with('OrderCheckoutDetailsData')
					  ->with('OrderItemData')->get();
    	// $order = Order::where('id',$orderid)->with('OrderCheckoutDetailsData')
    	// ->with(['OrderItemData'=>function($oitem) use($uid){
    	// 			  		$oitem->where('seller_id',$uid);
    	// }])->get();
		echo json_encode($order->toArray());
	}
	
	public function update_status(Request $request)
	{
		$orderid = $request->orderid;
		$optsel = $request->optsel;
		$order = Order::find($orderid);
		$order->status = $optsel;
		$uid = Auth::id();
		$msg = 'there is an Error Occured';
		$status = 'error';
		if($order->save()){

				$msg = 'Successfully update the order with code '.$order->order_code;
				$status = 'success';		
		}
		$whoorder = Order::where('id',$orderid)->with('OrderCheckoutDetailsData')
		->with(['OrderItemData'=>function($oitem) use($uid){
				$oitem->where('seller_id',$uid);
		  }])->get();
		  $user_id = User::where('id', 15)->get();
		  $settings =  Settings::get();
		  $email_address_tosent = '';
		  if($settings->count() > 0){
			  $settings_arr = $settings->toArray();
			  $email_address_tosent = $settings_arr[0]['email_address'];	
		}
			$user_content = EmailTemplate::get();
			$user_id = User::where('id', $whoorder[0]['customer_id'])->get();
			$order_details = Order::where('id',$orderid)->with('OrderCheckoutDetailsData')
			->with(['OrderItemData'=>function($oitem) use($uid){$oitem->where('seller_id',1);}])->get();


		foreach($user_id as $customer) 
		{
			//Send Email Here
			$user_add = UserAddress::where('user_id', $whoorder[0]['customer_id'])->get();
			$data = array(
				'fullname' 	 => $customer->name,
				'email' => $customer->email,
				'titlesubject' => $whoorder[0]['order_code'],
				'status' => $whoorder[0]['status'],
				'payment_type' => $whoorder[0]['payment_type'],
				'order_code' => $whoorder[0]['order_code'],
				'amount' => number_format($whoorder[0]['amount'],2),
				'amount_shipping' => number_format($whoorder[0]['amount_shipping'],2),
				'amount_total' => number_format($whoorder[0]['amount_total'],2),
				'amount_discount' => number_format($whoorder[0]['amount_discount'],2),
				'created_at' => $whoorder[0]['created_at'],

			);
			Mail::send('user.emailorder', compact('data', 'user_content', 'order_details'), function ($message) use($data, $settings, $order_details) {
					$message->sender($settings[0]['email_address']);
					$message->to($data['email'])->subject($data['titlesubject']);
					$message->embed(public_path() . '/img/banner-email.png');
					foreach($order_details as $item){
						for($i=0; count($item['OrderItemData']) < $i; $i++){
							//$item['OrderItemData'][$i]['id'];
							$message->embed(public_path() . Products::find('id', $item['OrderItemData'][$i]['id'])->value('featured_image'));
						}
					}
					switch ($data['status']){
						case 'on_process':
							$message->embed(public_path() . '/img/on_process.png');
							break;
						case 'for_shipping':
							$message->embed(public_path() . '/img/for_shipping.png');
							break;
						case 'completed':
							$message->embed(public_path() . '/img/completed.png');
							break;
						default:
					}
				});
			
				if (Mail::failures()) {
					print_r("asd"); exit();
				}
		}
		echo json_encode(array('msg'=>$msg,'status'=>$status));
		
	}
}
