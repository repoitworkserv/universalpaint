<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;

use Session;
use Mail;
use App\Product;
use App\Attribute;
use App\Shipping;
use App\Order;
use App\OrderItem;
use App\OrderCheckoutDetails;
use App\ShippingDimension;
use App\UserAddress;
use App\User;
use App\Settings;
use Validator;
use App\ShippingGngRates;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

define('MERCHANT_ID', 'RICHDON');
define('MERCHANT_PASSWORD', 'LKMnf94ncp21ccxa');
class CheckoutController extends Controller
{
    private $paypal_client;
    private $paypal_secret;

    public function __construct()
    {
        $this->paypal_client = 'AQx4nYSe8-ns0vEQpVjc97102A9w0edR1AmIR-A31oPU0VM4o00ANROaBxTWWlMNkLZwUXcpG4Mx-GZF';
        $this->paypal_secret = 'EFC077SStQNqmAgyocKGkaHSQAqwlz31PCdiBYDEZh7re_ZNU__0JGDm83nOgcyefZwCSTZRK4GbyBpm';
    }

    public function index(Request $request)
    {
        $shipping = ShippingGngRates::all();
        $cart = $request->session()->get('cart');
        $message = 'Shop now';
        if(empty($cart)){
            return redirect('products')->with('error', $message);
        }
        else {
            $sub_total = 0;
            for ($i=0; $i < count($cart); $i++) {
                $cart[$i]['product_data'] = Product::where('id', $cart[$i]['id'])->first();
                // print_r($cart[$i]);
                if ($cart[$i]['sale_price'] != 0) {
                    $sub_total += $cart[$i]['qty'] * $cart[$i]['sale_price'];
                } else {
                    $sub_total += $cart[$i]['qty'] * $cart[$i]['price'];
                }
            }
        }
        return view('user.product.checkout', compact('sub_total', 'shipping','cart' ));
    }

    public function send_checkoutDetails(Request $request)
    {        
        $validator = Validator::make($request->all(), [
			'billing_first_name'  => 'required',						
			'billing_last_name'   => 'required',
			'billing_address'            => 'required',
			'billing_email'         => 'required',
			'billing_mobile'		  => 'required',
            'billing_city'	=> 'required',
            'billing_note' => 'required',

		]);
        $message = '';
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."<br />";
            }
            $status = false;
        } else {
            $order_id = date("Y-m-d").'-'.str_random(12);
            $cart = $request->session()->get('cart');
            $order = new Order;
            $order->order_code              = $order_id; 
            $order->customer_id             = '';
            $order->payment_type            = 'queue'; 
            $order->invoice_no              = '';
        	$order->ref_no					= '';
            $order->status                  = 'pending';
            $order->amount                  = '';
            $order->amount_shipping         = '';
            $order->amount_total            = '';
            $order->amount_discount         = '';
            if($order->save()) {
                $cart = $request->session()->get('cart');
                foreach ($cart as $item) {
                    $order_item = new OrderItem;
                    $order_item->order_id           = $order->id;
                    $order_item->seller_id          = '1';
                    $order_item->product_name       = $item['name'];
                    if(!empty($item['product_attribute'])){
                        $order_item->product_details = Attribute::where('id', $item['product_attribute'])->first()['name'];
                    } else {
                        $order_item->product_details    = $item['description'];
                    }
                    $order_item->quantity           = $item['qty'];
                    $order_item->price              = $item['price'];
                    $order_item->discount           = $item['discount'];
                    $order_item->save();
                }
                $order_checkout_detail = new OrderCheckoutDetails;
                $order_checkout_detail->order_id            = $order->id;
                $order_checkout_detail->reference           = 'billing';
                $order_checkout_detail->lot_house_no        = $request->billing_address;
                $order_checkout_detail->city                = $request->billing_city;
                $order_checkout_detail->lname               = $request->billing_last_name;
                $order_checkout_detail->fname               = $request->billing_first_name;
                $order_checkout_detail->contact_no          = $request->billing_mobile;
                $order_checkout_detail->note                = $request->billing_note;
                $order_checkout_detail->save();
                $status = true;
                $data = array(
                    'fullname' 	 => $request->billing_first_name,
                    'email' => $request->billing_email,
                    'titlesubject' => $order->order_code,
                    'status' => $order->status,
                    'payment_type' => $order->payment_type,
                    'order_code' => $order->order_code,
                );
                $settings =  Settings::get();
                $order_details = Order::where('order_code',$order_id)->with('OrderItemData')->get();
                Mail::send('user.emailorder', compact('data', 'user_content', 'order_details'), function ($message) use($data, $settings, $order_details) {
                    dd($settings);
                            $message->sender($settings[0]['email_address']);
                            $message->to($data['email'])->subject($data['titlesubject']);
                            //$message->embed(public_path() . '/img/banner-email.png');
                        });
                    
                        if (Mail::failures()) {
                            print_r("asd"); exit();
                        }
                    }
                }
            Session::forget('cart');
            echo json_encode(array('status' => $status, 'message' => $message));
    }

    public function payment_dragonpay(Request $request) 
    {
        $uid = Auth::id();

        $usermail = User::where('id', $uid)->get();
        $settings =  Settings::get();
        $billing_validator = array(
            'billing_first_name'          => 'required',
            'billing_last_name'           => 'required',
            'billing_address'             => 'required',
            'billing_email'               => 'required|email',
            'billing_mobile'              => 'required',
            'billing_city'                => 'required'
        );
        $shipping_validator = array(
            'shipping_first_name'          => 'required',
            'shipping_last_name'           => 'required',
            'shipping_address'             => 'required',
            'shipping_email'               => 'required|email',
            'shipping_mobile'              => 'required',
            'shipping_city'                => 'required'
        );
        
        if($request->is_shipping == 'true') {
            $check_valid = array_merge($billing_validator,$shipping_validator);
        } else {
            $check_valid = $billing_validator;
        }
        $validator = Validator::make($request->all(), $check_valid);
        $message = '';
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."<br />";
            }
            $status = false;
        } else {
            $cart = $request->session()->get('cart');
            $sub_total = 0;
            $total_volume = 0;
            $total_weight = 0;
            for ($i=0; $i < count($cart); $i++) {
                $price = $cart[$i]['sale_price'] == '' || $cart[$i]['sale_price'] == 0 ? $cart[$i]['price'] : $cart[$i]['sale_price'];
                $cart[$i]['product_data'] = Product::where('id', $cart[$i]['id'])->first();
                $discount_type = $cart[$i]['product_data'];
                $sub_total += $cart[$i]['qty'] * $price;
                $total_weight += $cart[$i]['shipping_weight'];
                $total_volume += ($cart[$i]['shipping_width'] * $cart[$i]['shipping_length'] * $cart[$i]['shipping_height']) * $cart[$i]['qty'];
            }
            $location = $request->shipping_city ? $request->shipping_city : $request->billing_city;
            $shipping_rate = $this->calculate_shipping($location, $total_volume, $total_weight);
            $order_id = str_random(12);
            $order_description = 'Customer ID: ' . Auth::id() . ' Sub Total: ' . $sub_total . ' Shipping: ' . $shipping_rate . ' Total Amount: '. number_format(($sub_total + $shipping_rate), 2, '.', '');
            $order = new Order;
            $order->order_code              = $order_id; 
            $order->customer_id             = Auth::id();
            $order->payment_type            = 'dragonpay'; 
            $order->invoice_no              = '';
        	$order->ref_no					= '';
            $order->status                  = 'pending';
            $order->amount                  = $sub_total;
            $order->amount_shipping         = $shipping_rate;
            $order->amount_total            = $sub_total + $shipping_rate;
            $order->amount_discount         = '';
            
            if($order->save()) {
                $cart = $request->session()->get('cart');
                foreach ($cart as $item) {
                    $order_item = new OrderItem;
                    $order_item->order_id           = $order->id;
                    $order_item->seller_id          = '1';
                    $order_item->product_name       = $item['name'];
                    if(!empty($item['product_attribute'])){
                        
                        $variants_details = array();
                        for($i = 0; $i < count($item['product_attribute']); $i++){
                            $variants_details[] = Attribute::where('id', $item['product_attribute'][$i])->first()['name'];
                            //array_push($variants_details, $value);
                        } 
                        $order_item->product_details = join(', ', $variants_details).' '.$item['description'];
                    } else {
                        $order_item->product_details    = $item['description'];
                    }
                    $order_item->quantity           = $item['qty'];
                    $order_item->price              = $item['price'];
                    $order_item->discount           = $item['discount'];
                    $order_item->discount_type      = $item['discount_type'];
                    if($discount_type->discount_type == 'percentage') {
                        $order_item->total_amount = $item['price'] - $item['price'] * ($item['discount'] / 100 );
                    }
                    elseif ($discount_type->discount_type == 'fix'){
                        $order_item->total_amount = $item['sale_price']  * $item['qty'];
                    }
                    else {
                        $order_item->total_amount = $item['price'] * $item['qty'];
                    }
                    //dd('new_order', $order_item, 'item',$item);
                    $order_item->save();
                }
                $order_checkout_detail = new OrderCheckoutDetails;
                $order_checkout_detail->order_id            = $order->id;
                $order_checkout_detail->reference           = 'billing';
                $order_checkout_detail->lot_house_no        = $request->billing_address;
                $order_checkout_detail->city                = $request->billing_city;
                $order_checkout_detail->lname               = $request->billing_last_name;
                $order_checkout_detail->fname               = $request->billing_first_name;
                $order_checkout_detail->contact_no          = $request->billing_mobile;
                $order_checkout_detail->note                = $request->billing_note;
                $order_checkout_detail->save();
                if($request->is_shipping == 'true') {
                    $order_checkout_detail = new OrderCheckoutDetails;
                    $order_checkout_detail->order_id            = $order->id;
                    $order_checkout_detail->reference           = 'shipping';
                    $order_checkout_detail->lot_house_no        = $request->shipping_address;
                    $order_checkout_detail->city                = $request->shipping_city;
                    $order_checkout_detail->lname               = $request->shipping_last_name;
                    $order_checkout_detail->fname               = $request->shipping_first_name;
                    $order_checkout_detail->contact_no          = $request->shipping_mobile;
                    $order_checkout_detail->note                = $request->shipping_note;
                    $order_checkout_detail->save();
                }
            }
            $parameters = array(
                'merchantid' => MERCHANT_ID,
                'txnid' => $order_id,
                'amount' => number_format(($sub_total + $shipping_rate), 2, '.', ''),
                'ccy' => 'PHP',
                'description' => $order_description,
                'email' => $request->billing_email,
            );
            
            $parameters['key'] = MERCHANT_PASSWORD;
            $digest_string = implode(':', $parameters);
            unset($parameters['key']);
            $parameters['digest'] = sha1($digest_string);
            $url = 'http://test.dragonpay.ph/Pay.aspx?';
    
            $url .= http_build_query($parameters, '', '&');  
            $message = $url;
            $status = true;
        }
            $datas = array(['fullname' => $usermail[0]['name'],'emailadd'=>$usermail[0]['email']]);
       		Mail::send('user.onlineregister', compact('datas'), function ($message) use($settings, $datas) {
           	$message->sender($settings[0]['email_address']);
            $message->to($datas[0]['emailadd'])->subject('Order Pending');
            $message->embed(public_path() . '/img/banner-email.png');

        });
    
        if (Mail::failures()) {
            print_r("asd"); exit();
        }
        Session::forget('cart');
        echo json_encode(array('status' => $status, 'message' => $message));

    }

    public function payment_dragonpay_postback(Request $request)
    {
        switch ($_POST['status']) {
            case 'S': 
                $status = 'success';
                break;
            case 'F': 
                $status = 'failure';
                break;
            case 'P': 
                $status = 'pending';
                break;
            case 'U': 
                $status = 'unknown';
                break;
            case 'R': 
                $status = 'refund';
                break;
            case 'K': 
                $status = 'chargeback';
                break;
            case 'V': 
                $status = 'void';
                break;
            case 'A': 
                $status = 'authorized';
                break;
        }

        Order::where('order_code',$_POST['txnid'])->update(['status'=>$status]);

        echo "result=OK";
    }

    public function payment_dragonpay_return(Request $request)
    {
        switch ($_GET['status']) {
            case 'S': 
                $status = 'success';
                $message = 'Your Order has been successfully placed. Thank you';
                break;
            case 'F': 
                $status = 'failure';
                $message = 'Problem has occur';
                break;
            case 'P': 
                $status = 'pending';
                $message = 'Transaction status is pending';
                break;
            case 'U': 
                $status = 'unknown';
                $message = 'Problem has occur';
                break;
            case 'R': 
                $status = 'refund';
                $message = 'Transaction status is pending';
                break;
            case 'K': 
                $status = 'chargeback';
                $message = 'Transaction status is pending';
                break;
            case 'V': 
                $status = 'void';
                $message = 'Transaction status is pending';
                break;
            case 'A': 
                $status = 'authorized';
                $message = 'Transaction status is pending';
                break;
        }

        Order::where('order_code',$_GET['txnid'])->update(['status'=>$status]);
    	Order::where('order_code',$_GET['txnid'])->update(['ref_no'=>$_GET['refno']]);
    	$uid = Auth::id();
    	$txnid = $_GET['txnid'];
    	$refno = $_GET['refno'];
		Session::forget('cart');
        $request->session()->flash('status', $message);
        return view('user.thankyou',compact('refno','uid','txnid','message'));
    }

    public function payment_paypal_create_b01112019(Request $request) 
    {
        $cart = $request->session()->get('cart');
        $sub_total = 0;
        $list = array();
        $total_volume = 0;
        $total_weight = 0;
        foreach ($cart as $item) {
            $price = $item['sale_price'] == '' || $item['sale_price'] == 0 ? $item['price'] : $item['sale_price'];
            array_push($list, array(
                'name'=>$item['name'],
                'description'=>$item['description'],
                'quantity'=>$item['qty'],
                'price'=>$price,
                'tax'=>'0.00',
                'sku'=>$item['id'],
                'currency'=> 'PHP'));
            $sub_total += $price * $item['qty'];
            $total_weight += $item['shipping_weight'];
            $total_volume += ($item['shipping_width'] * $item['shipping_length'] * $item['shipping_height']) * $item['qty'];
        }
        $location = $request->shipping_city ? $request->shipping_city : $request->billing_city;
        $shipping_rate = $this->calculate_shipping($location, $total_volume, $total_weight);
        
        $data = "grant_type=client_credentials";
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$this->paypal_client:$this->paypal_secret");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Accept-Language: en_US',
            'Content-Type: application/x-www-form-urlencoded',
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = json_decode(curl_exec($ch), true);
        curl_close($ch);
        // print_r($response);die();
        $access_token = $response['access_token'];

        $data = array(
            'intent' => 'sale',
            'redirect_urls' => array(
                'return_url' => 'gng.dev.com',
                'cancel_url' => 'gng.dev.com'
            ),
            'payer' => array(
                'payment_method' => 'paypal'
            ),
            'transactions' => array(
                array(
                    'amount' => array(
                        'total' => number_format(($sub_total + $shipping_rate), 2),
                        'currency' => 'PHP',
                        'details' => array(
                            'subtotal' => number_format($sub_total, 2),
                            'tax' => 0.00,
                            'shipping' => $shipping_rate,
                            'handling_fee' => 0.00,
                            'shipping_discount' => 0.00,
                            'insurance' => 0.00
                        )
                    ),
                    'description' => 'test description',
                    'item_list' => array(
                        'items' => $list
                    )
                )
            )
        );
        $data = json_encode($data);
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/payments/payment");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Accept-Language: en_US',
            'Content-Type: application/json',
            'Authorization: Bearer '.$access_token,
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result  = curl_exec($ch);
        curl_close($ch);
        echo json_encode($result); 
    }

    public function payment_paypal_create(Request $request) 
    {
        $billing_validator = array(
            'billing_first_name'          => 'required',
            'billing_last_name'           => 'required',
            'billing_address'             => 'required',
            'billing_email'               => 'required|email',
            'billing_mobile'              => 'required',
            'billing_city'                => 'required'
        );
        $shipping_validator = array(
            'shipping_first_name'          => 'required',
            'shipping_last_name'           => 'required',
            'shipping_address'             => 'required',
            'shipping_email'               => 'required|email',
            'shipping_mobile'              => 'required',
            'shipping_city'                => 'required'
        );
        if($request->is_shipping == 'true') {
            $check_valid = array_merge($billing_validator,$shipping_validator);
        } else {
            $check_valid = $billing_validator;
        }
        $validator = Validator::make($request->all(), $check_valid);
        $message = '';
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."<br />";
            }
            echo json_encode(array('message' => $message, 'status' => 'failed'));
        } else {
            $cart = $request->session()->get('cart');
            $sub_total = 0;
            $list = array();
            $total_volume = 0;
            $total_weight = 0;
            foreach ($cart as $item) {
                $price = $item['sale_price'] == '' || $item['sale_price'] == 0 ? $item['price'] : $item['sale_price'];
                array_push($list, array(
                    'name'=>$item['name'],
                    'description'=>$item['description'],
                    'quantity'=>$item['qty'],
                    'price'=>$price,
                    'tax'=>'0.00',
                    'sku'=>$item['id'],
                    'currency'=> 'PHP'));
                $sub_total += $price * $item['qty'];
                $total_weight += $item['shipping_weight'];
                $total_volume += ($item['shipping_width'] * $item['shipping_length'] * $item['shipping_height']) * $item['qty'];
            }
            $location = $request->shipping_city ? $request->shipping_city : $request->billing_city;
            $shipping_rate = $this->calculate_shipping($location, $total_volume, $total_weight);
            
            $data = "grant_type=client_credentials";
            $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_USERPWD, "$this->paypal_client:$this->paypal_secret");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'Accept-Language: en_US',
                'Content-Type: application/x-www-form-urlencoded',
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response  = json_decode(curl_exec($ch), true);
            curl_close($ch);
            // print_r($response);die();
            $access_token = $response['access_token'];
    
            $data = array(
                'intent' => 'sale',
                'redirect_urls' => array(
                    'return_url' => url('/').'/checkout',
                    'cancel_url' => url('/').'/checkout'
                ),
                'payer' => array(
                    'payment_method' => 'paypal'
                ),
                'transactions' => array(
                    array(
                        'amount' => array(
                            'total' => number_format(($sub_total + $shipping_rate), 2),
                            'currency' => 'PHP',
                            'details' => array(
                                'subtotal' => number_format($sub_total, 2),
                                'tax' => 0.00,
                                'shipping' => $shipping_rate,
                                'handling_fee' => 0.00,
                                'shipping_discount' => 0.00,
                                'insurance' => 0.00
                            )
                        ),
                        'description' => 'Order Code = '.str_random(12),
                        'item_list' => array(
                            'items' => $list
                        )
                    )
                )
            );
            $data = json_encode($data);
            $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/payments/payment");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'Accept-Language: en_US',
                'Content-Type: application/json',
                'Authorization: Bearer '.$access_token,
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result  = curl_exec($ch);
            curl_close($ch);
            echo json_encode(array('message' => $result, 'status' => 'sucess'));
        }
    }

    public function payment_paypal_execute(Request $request)
    {
        $uid = Auth::id();
        $usermail = User::where('id', $uid)->get();
        $settings =  Settings::get();
        $data = "grant_type=client_credentials";
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$this->paypal_client:$this->paypal_secret");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Accept-Language: en_US',
            'Content-Type: application/x-www-form-urlencoded',
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = json_decode(curl_exec($ch), true);
        curl_close($ch);      
        $access_token = $response['access_token'];

        $data = '{
            "payer_id" : "'.$request->payerID.'"
          }';
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/payments/payment/".$request->paymentID.'/execute');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$this->paypal_client:$this->paypal_secret");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Accept-Language: en_US',
            'Content-Type: application/json',
            'Authorization: Bearer '.$access_token,
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result  = json_decode(curl_exec($ch), true);
        curl_close($ch);
        // echo json_encode($result);
        // print_r($result);
        // print_r($result['state']);
        
        $cart = $request->session()->get('cart');
        $sub_total = 0;
        $total_volume = 0;
        $total_weight = 0;
        foreach ($cart as $item) {
            $price = $item['sale_price'] == '' || $item['sale_price'] == 0 ? $item['price'] : $item['sale_price'];
            $cart[0]['product_data'] = Product::where('id', $cart[0]['id'])->first();
            $discount_type = $cart[0]['product_data'];
            $sub_total += $price * $item['qty'];
            $total_weight += $item['shipping_weight'];
            $total_volume += ($item['shipping_width'] * $item['shipping_length'] * $item['shipping_height']) * $item['qty'];
        }
        $location = $request->shipping_city ? $request->shipping_city : $request->billing_city;
        $shipping_rate = $this->calculate_shipping($location, $total_volume, $total_weight);
        $order = new Order;
        $order->order_code              = str_replace('Order Code = ', '', $result['transactions'][0]['description']); 
        $order->customer_id             = Auth::id();
        $order->payment_type            = 'paypal'; 
        $order->invoice_no              = '';
        $order->status                  = 'pending';
        $order->amount                  = $sub_total;
        $order->amount_shipping         = $shipping_rate;
        $order->amount_total            = $sub_total + $shipping_rate;
        $order->amount_discount         = '';
        if($order->save()) {
            $cart = $request->session()->get('cart');
            foreach ($cart as $item) {
                $order_item = new OrderItem;
                $order_item->order_id           = $order->id;
                $order_item->seller_id          = '1';
                $order_item->product_name       = $item['name'];
                if(!empty($item['product_attribute'])){
                        
                    $variants_details = array();
                    for($i = 0; $i < count($item['product_attribute']); $i++){
                        $variants_details[] = Attribute::where('id', $item['product_attribute'][$i])->first()['name'];
                        //array_push($variants_details, $value);
                    } 
                    $order_item->product_details = join(', ', $variants_details).' '.$item['description'];
                } else {
                    $order_item->product_details    = $item['description'];
                }
                $order_item->quantity           = $item['qty'];
                $order_item->price              = $item['price'];
                $order_item->discount           = $item['discount'];
                $order_item->discount_type      = $discount_type->discount_type;
                if($discount_type->discount_type == 'percentage') {
                    $order_item->total_amount       = $item['price'] - $item['price'] * ($item['discount'] / 100 );
                }
                elseif ($discount_type->discount_type == 'fix'){
                    $order_item->total_amount       = $item['price'] - $item['discount'] * $item['qty'];
                }
                else {
                    $order_item->total_amount       = $item['price'] * $item['qty'];
                }
                $order_item->save();
            }
            $order_checkout_detail = new OrderCheckoutDetails;
            $order_checkout_detail->order_id            = $order->id;
            $order_checkout_detail->reference           = 'billing';
            $order_checkout_detail->lot_house_no        = $request->billing_address;
            $order_checkout_detail->city                = $request->billing_city;
            $order_checkout_detail->lname               = $request->billing_last_name;
            $order_checkout_detail->fname               = $request->billing_first_name;
            $order_checkout_detail->contact_no          = $request->billing_mobile;
            $order_checkout_detail->note                = $request->billing_note;
            $order_checkout_detail->save();
            if($request->is_shipping == 'true') {
                $order_checkout_detail = new OrderCheckoutDetails;
                $order_checkout_detail->order_id            = $order->id;
                $order_checkout_detail->reference           = 'shipping';
                $order_checkout_detail->lot_house_no        = $request->shipping_address;
                $order_checkout_detail->city                = $request->shipping_city;
                $order_checkout_detail->lname               = $request->shipping_last_name;
                $order_checkout_detail->fname               = $request->shipping_first_name;
                $order_checkout_detail->contact_no          = $request->shipping_mobile;
                $order_checkout_detail->note                = $request->shipping_note;
                $order_checkout_detail->save();
            }
        }
    	$datas = array(['fullname' => $usermail[0]['name'], 'emailadd' => $usermail[0]['email']]);
		Mail::send('user.onlineregister', compact('datas'), function ($message) use($datas, $settings) {
            $message->sender($settings[0]['email_address']);
            $message->to($datas[0]['emailadd'])->subject('Order Pending');
            $message->embed(public_path() . '/img/banner-email.png');

        });
    
        if (Mail::failures()) {
            print_r("asd"); exit();
         }
		Session::forget('cart');
        //$request->session()->('cart')->first();
        $request->session()->flash('status', 'Your Order has been successfully placed. Thank you');
    }

    public function calculate_shipping($location, $volume, $weight)
    {
       $shipping_dimension = ShippingDimension::whereRAW(DB::raw('weight >= ?'), [$weight])->first();
            
        switch(!empty($shipping_dimension)) {
            case ($shipping_dimension['size'] == '0kg-0.50kg'):
                $shipping = ShippingGngRates::where('id', $location)->first()['below05kg'];
                break;

            case ($shipping_dimension['size'] == '0.50kg-1kg'):
                $shipping = ShippingGngRates::where('id', $location)->first()['below1kg'];
                break;

            case ($shipping_dimension['size'] == '1kg-3kg'):
                $shipping = ShippingGngRates::where('id', $location)->first()['below3kg'];
                break;
        
            case ($shipping_dimension['size'] == '3kg-4kg'):
                $shipping = ShippingGngRates::where('id', $location)->first()['below4kg'];
                break;
            
            case ($shipping_dimension['size'] == '4kg-5kg'):
                $shipping = ShippingGngRates::where('id', $location)->first()['below5kg'];
                break;
            
            case ($shipping_dimension['size'] == '5kg-6kg'):
                $shipping = ShippingGngRates::where('id', $location)->first()['below6kg'];
                break;
            
            case ($shipping_dimension['size'] == '6kg-7kg'):
                $shipping = ShippingGngRates::where('id', $location)->first()['below7kg'];
                break;

            case ($shipping_dimension['size'] == '7kg-8kg'):
                $shipping = ShippingGngRates::where('id', $location)->first()['below8kg'];
                break;

            case ($shipping_dimension['size'] == '8kg-9kg'):
                $shipping = ShippingGngRates::where('id', $location)->first()['below9kg'];
                break;
            
            case ($shipping_dimension['size'] == '9kg-10kg'):
                $shipping = ShippingGngRates::where('id', $location)->first()['below10kg'];
                break;
        
            case ($shipping_dimension['size'] == '10kg-11kg'):
                $shipping = ShippingGngRates::where('id', $location)->first()['below11kg'];
                break;

            case ($shipping_dimension['size'] == '11kg-12kg'):
                $shipping = ShippingGngRates::where('id', $location)->first()['below12kg'];
                break;

            case ($shipping_dimension['size'] == '12kg-13kg'):
                $shipping = ShippingGngRates::where('id', $location)->first()['below13kg'];
                break;

            case ($shipping_dimension['size'] == '13kg-14kg'):
                $shipping = ShippingGngRates::where('id', $location)->first()['below14kg'];
                break;

            case ($shipping_dimension['size'] == '15kg-16kg'):
                $shipping = ShippingGngRates::where('id', $location)->first()['below16kg'];
                break;

            case ($shipping_dimension['size'] == '16kg-17kg'):
                $shipping = ShippingGngRates::where('id', $location)->first()['below17kg'];
                break;

            case ($shipping_dimension['size'] == '17kg-18kg'):
                $shipping = ShippingGngRates::where('id', $location)->first()['below18kg'];
                break;

            case ($shipping_dimension['size'] == '18kg-19kg'):
                $shipping = ShippingGngRates::where('id', $location)->first()['below19kg'];
                break;

            case ($shipping_dimension['size'] == '19kg-20kg'):
                $shipping = ShippingGngRates::where('id', $location)->first()['below20kg'];
                break;


            default:
                $shipping = '';
         }

         return number_format($shipping, 2);
    }
}
