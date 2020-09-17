<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//Model
use App\PaymentMethod;
use App\ProductCategory;
use App\Product;
use App\Order;
use App\OrderItem;
use App\OrderUserInfo;
use Auth;

class OrderPageController extends Controller
{

    public function index(){
        $uid = Auth::id();
        $order = Order::with('OrderCheckoutDetailsData')
        ->with('OrderItemData')->where('customer_id',$uid)->orderBy('created_at', 'desc')->paginate(5);

    	return view('customer.orders',compact('uid','order'));
    }
    /**
     *  Process user's payment
     *
     * @param  \App\Http\Requests\PaginationRequest $request
     * @return \Response
     */
    public function process_payment(Request $request)
    {   

        $this->validate($request, [
            'company' => 'required',
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'address' => 'required',
            'province' => 'required',
            'city' => 'required',
            'postal' => 'required'
        ]);



        $product_cart_session = $request->session()->get('product_cart');

        $total_price = 0;
        $total_qty = 0;
        foreach($product_cart_session as $key => $val) {

            $total_qty = $total_qty + $val['qty'];
            $total_price = $total_price + ($val['qty'] * $val['price']);
        
        }

        //save on `orders` table

        $txnid = strtoupper(substr(sha1(rand()), 0, 10));

        $order = new Order;

        $order->txn_id         = $txnid;
        $order->status         = 'paid';
        $order->payment_method = $request->paymentMethod;
        $order->total_price    = $total_price;
        $order->total_quantity = $total_qty; 
        $order->order_date     = date("Y-m-d");
        $order->delivery_date  = date("Y-m-d");

        $order->save();


        foreach($product_cart_session as $key => $val) {

            //save on `order_items` table

            $order_item = new OrderItem;

            $order_item->order_id   = $order->id;
            $order_item->product_id = $val['prod_id'];
            $order_item->quantity   = $val['qty'];
            $order_item->price      = $val['price'];
            $order_item->sub_total  = $val['qty']*(int)$val['price']; 

            $order_item->save();
        
        }

        //save on `order_user_infos` table

        $order_user = new OrderUserInfo;

        $order_user->order_id = $order->id;
        $order_user->user_id  = \Auth::user()->id;
        $order_user->company  = $request->company;
        $order_user->name     = $request->name;
        $order_user->email    = $request->email;
        $order_user->mobile   = $request->mobile;
        $order_user->address  = $request->address;
        $order_user->province = $request->province;
        $order_user->city     = $request->city;
        $order_user->postal   = $request->postal;

        $order_user->company2  = $request->company2;
        $order_user->name2     = $request->name2;
        $order_user->email2    = $request->email2;
        $order_user->mobile2   = $request->mobile2;
        $order_user->address2  = $request->address2;
        $order_user->province2 = $request->province2;
        $order_user->city2     = $request->city2;
        $order_user->postal2   = $request->postal2;

        $order_user->save();


        //delete session
        $request->session()->forget('product_cart');
        $request->session()->forget('total_cart');

        if($request->paymentMethod == "paypal") {

            //PAYPAL payment method


        } else if($request->paymentMethod == "dragonpay") {

            //DRAGON PAY payment method

            $parameters = array(
              'merchantId' => 'OPTIUM',
              'txnid' => $txnid,
              'amount' => $total_price,
              'ccy' => 'PHP',
              'description' => 'Description of order',
              'email' => 'sample@merchant.ph', 
              'key' => 'vM8iq5eA1fWcBXQ'
            );
            
            $parameters['amount'] = number_format($parameters['amount'], 2, '.', '');

            $digest_string = implode(':', $parameters);
            echo $digest_string.'<br>';
            echo sha1($digest_string).'<br>';

            $parameters['digest'] = sha1($digest_string);

            unset($parameters['key']);

            $link = http_build_query($parameters, '', '&');
            $redirect_url = "https://test.dragonpay.ph/Pay.aspx?".$link;

            header( "Location:".$redirect_url."" );
            die;

        } else {

            //BANK DEPOSIT payment method

            //return redirect('bank_details');
            return redirect()->action('User\OrderPageController@bank_details');

        }

        
    }


    /**
     *  Bank details page
     *
     * @param  none
     * @return \Response
     */
    public function bank_details()
    { 

        $product_categories = ProductCategory::select('id', 'name')->get();

        $bank_details = PaymentMethod::where('method', '=', 'bank_deposit')
                                ->where('key', '=', 'details')
                                ->get();

        if(isset($bank_details[0]['value'])){
            
            $bank_details = $bank_details[0]['value'];

        } else {

            $bank_details = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

        }


        return view('user.order.bank_details', compact('bank_details', 'product_categories'));

    }

}
