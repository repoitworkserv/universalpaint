<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Product;
use App\Shipping;
use App\ShippingDimension;
use App\ShippingGngRates;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;

class CartController extends Controller
{
    public function index(Request $request)
    { 
        $shipping = ShippingGngRates::all();
        $cart = $request->session()->get('cart'); 

        $uid = Auth::id();
        $sub_total = 0;
        $total = 0;
        $message = "Your Cart is Empty";
        if(!$cart){
            return view('user/product/cart', compact('cart', 'sub_total', 'shipping', 'uid'))->withErrors(['msg', 'The Message']);
        }else{
            $shipping[0]['shipping_data'] = Product::where('id', $cart[0]['id'])->first();
            for ($i=0; $i < count($cart); $i++) {
                $cart[$i]['product_data'] = Product::where('id', $cart[$i]['id'])->first();
                if ($cart[$i]['sale_price'] != 0) {
                    //if()
                    $sub_total += $cart[$i]['qty'] * $cart[$i]['sale_price'];
                    
                }
                else {
                    $sub_total += $cart[$i]['qty'] * $cart[$i]['price'];
                }
            $total = $sub_total;
            }
            return view('user/product/cart', compact('total', 'cart', 'sub_total', 'shipping', 'uid'));
        }
    }

    public function update(Request $request)
    {

    }

    public function addcart(Request $request)
    {                
        $return_arr = array();        
        //Submit Multiple Items Here
        $multi = isset($request->multiple) ? $request->multiple : false;
        $productid = $request->productid;        

        if($multi != false){                                      
            $product = Product::whereIn('id',$productid)->get();            
            foreach($product as $prod){
                $item = [
                    'id' => $prod->id,    
                    'name' => '',
                    'qty' => 1,                    
                    'price' => 1,
                    'discount' => 0,
                    'discount_type' => 0,
                    'sale_price' => 0,
                    'description' => 0,
                    'shipping_weight' => 0,
                    'shipping_height' => 0,
                    'shipping_length' => 0,
                    'shipping_width' => 0,
                    'is_sale' => 0,
                    'product_attribute' => $request['prod-attri'], 
                ];
                
                 if($request->session()->has('cart')) {
                    $cart = $request->session()->get('cart');
                    $key = array_search($prod->id, array_column($cart, 'id'));
                    $ids = array_column($cart, 'id', 'id');
                    if(isset($ids[$prod->id])) {
                        $cart[$key]['qty'] += 1;
                        $request->session()->put('cart', $cart);                        
                    } else {
                        $request->session()->push('cart', $item);
                    }
                }else{
                    $request->session()->push('cart', $item);
                }
            }   
            // $cart = $request->session()->get('cart');  
            // echo json_encode($cart);
            // exit;

            
            // $message = "Item is successfully added to cart";            
            // return redirect()->back()->with('success', $message);      
            $product = Product::where('id',$request->parent_id)->get();
            // echo json_encode($product[0]->slug_name);
            
            // return redirect()->route('product', ['id' => $product[0]->slug_name]);     
            // return redirect()->route('product', ['id' => $product[0]->slug_name]); 
            // return redirect('/product'.'/'. $product[0]->slug_name);
            $url = '/product/'. $product[0]->slug_name.'?color_swatches=true&parent_id='. $product[0]->id;
            // $url = '/product/'. $product[0]->slug_name.'?color_swatches=true&';
            $data = array(
                'msg' => 'success',
                'url' => $url
            );
            echo json_encode($data); 
            exit;
        }else{
                
            if($user = Auth::user()) {
                $item = [
                    'id' => $request->item_id,
                    'name' => $request->item_name,
                    'qty' => $request->item_quantity,
                    'price' => $request->item_price,
                    'discount' => $request->item_discount,
                    'discount_type' => $request->item_discount_type,
                    'sale_price' => $request->item_sale_price,
                    'description' => $request->item_description,
                    'shipping_weight' => $request->shipping_weight,
                    'shipping_height' => $request->shipping_height,
                    'shipping_length' => $request->shipping_length,
                    'shipping_width' => $request->shipping_width,
                    'is_sale' => $request->item_is_sale,
                	'product_attribute' => $request['prod-attri'], 
                ];
                if ($request->session()->has('cart')) {
                    $cart = $request->session()->get('cart');
                    $key = array_search($request->item_id, array_column($cart, 'id'));
                    $ids = array_column($cart, 'id', 'id');
                    if(isset($ids[$request->item_id])) {
                        $cart[$key]['qty'] += $request->item_quantity;
                        $request->session()->put('cart', $cart);
                    } else {
                        $request->session()->push('cart', $item);
                    }
                }
                else {
                    $request->session()->push('cart', $item);
                }
                $message = "Item is successfully added to cart";
            	$return_arr = array('msg'=>$message,'status'=>"success");
            } else {
                $message = "Please Login first before adding to cart.";
            	$return_arr = array('msg'=>$message,'modalshow'=>'show','status'=>'error','addcart'=>'');
            }
    
            return redirect()->back()->with('success', $message);
        }
    }

    public function getdimension(Request $request)
    {
        $shippingdimension = ShippingDimension::all();
        echo json_encode($shippingdimension);
    }

    public function removecart(Request $request)
    {
        $cart = $request->session()->get('cart');
        array_splice($cart, $request->cart_id, 1);
        $request->session()->put('cart', $cart);
        echo json_encode('ok');
    }

    public function checkcart(Request $request)
    {
        $cart = $request->session()->get('cart');
        $selected_item = $cart[$request->cart_id];
        $selected_product = Product::where('id', $selected_item['id'])->first();
        $cart = $request->session()->get('cart');
        if($request->qty > $selected_product['quantity']) {
            $cart[$request->cart_id]['qty'] = $selected_product['quantity'];
        } else {
            $cart[$request->cart_id]['qty'] = $request->qty;
        }
        $request->session()->put('cart', $cart);
        echo json_encode($selected_product);
    }

    public function get_shipping(Request $request) 
    {
        $cart = $request->session()->get('cart');
        $total_volume = 0;
        $total_weight = 0;
        foreach ($cart as $item) {
            $total_weight += $item['shipping_weight'] * $item['qty'];
            $total_volume += ($item['shipping_width'] * $item['shipping_length'] * $item['shipping_height']) * $item['qty'];
        }
        $location = $request->location;
        $shipping_rate = $this->calculate_shipping($location, $total_volume, $total_weight);
        echo json_encode($shipping_rate);
    }

    public function calculate_shipping($location, $volume, $weight) {

        //$shipping_dimension = ShippingDimension::whereRAW(DB::raw('length * width * height >= ?'), [$volume])->first();
            
        $shipping_dimension = ShippingDimension::whereRAW(DB::raw('weight >= ?'), [$weight])->first();
    	$max = ShippingGngRates::where('id', $location)->first()['below20kg'];
        //dd($shipping_dimension, $volume, $weight);
        //dd($shipping_dimension['size'] == '0kg-0.50kg');
        switch(!empty($shipping_dimension)) {
        	case ($shipping_dimension == null):
                $shipping = ShippingGngRates::where('id', $location)->first()['below20kg'];
                break;

        	case ($shipping_dimension['size'] == '19kg-20kg'):
                $shipping = ShippingGngRates::where('id', $location)->first()['below20kg'];
                break;
        
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

        	// case ($shipping_dimension['size'] == 'null'):
        	// 	$shipping = $max;
        	// 	break;
        
            default:
				$shipping = $max;
         }

         return number_format($shipping, 2);
    }
}