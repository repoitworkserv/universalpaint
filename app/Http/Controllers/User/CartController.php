<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Product;
use App\Shipping;
use App\ShippingDimension;
use App\ShippingGngRates;
use App\Attribute;
use App\ProductAttribute;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use Validator;

class CartController extends Controller
{
    public function index(Request $request)
    { 
        $shipping = ShippingGngRates::all();
        $cart = $request->session()->get('gocart');
        $arr_color = [];
        $uid = Auth::id();
        return view('user/product/cart', compact('cart', 'uid'));
    }

    public function update(Request $request)
    {

    }



    public function coloraddtocart(Request $request){
        $message = '';
        //Session::forget('requestqoute');
        if($request->productName == null){
            $message = "Item is unavailable!";
            return redirect()->back()->with('error', $message);
        } else {
            $productid = $request->productName;
            $attribute = $request->colorChoose;
            $csscolor = $request->colorCss;
            $colorname = $request->colorNameP;
            $product = Product::where('id', $productid)->get();
            $item = [
                'id' => $product[0]['id'],    
                'name' => $product[0]['name'],
                'qty' => 1,                    
                'price' => $product[0]['price'],
                'discount' => $product[0]['discount'],
                'discount_type' => $product[0]['discount_type'],
                'sale_price' => $product[0]['sale_price'],
                'description' =>  $product[0]['description'],
                'shipping_weight' => $product[0]['shipping_weight'],
                'shipping_height' => $product[0]['shipping_height'],
                'shipping_length' => $product[0]['shipping_length'],
                'shipping_width' => $product[0]['shipping_width'],
                'is_sale' => $product[0]['is_sale'],
                'product_attribute' => $attribute,
                'css_color' => $csscolor,
                'color_name' => $colorname
            ];
            if ($request->session()->has('requestqoute')) {
                $cart = $request->session()->get('requestqoute');
                $key = array_search($request->item_id, array_column($cart, 'id'));
                $ids = array_column($cart, 'id', 'id');
                if(isset($ids[$request->item_id])) {
                    $cart[$key]['qty'] += $request->item_quantity;
                    $request->session()->put('requestqoute', $cart);
                } else {
                    $request->session()->push('requestqoute', $item);
                }
                $message = "Item is successfully added to cart";
            }
            else {
                $request->session()->push('requestqoute', $item);
                $message = "Item is successfully added to cart";
            }
            return redirect()->back()->with('success', $message);
        }
        
    }

    public function colorSwatchesAddToCart(Request $request){
        $message = '';
        //Session::forget('requestqoute');

        $validator = Validator::make($request->all(), [
            'productId'   => 'required',
            'productName' => 'required',
            'colorChoose' => 'required',
            'colorCss' => 'required',
            'colorNameP' => 'required',
            'quantity' => 'required'
        ]);
        $message = '';
        if($validator->fails()){
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
            return redirect()->back()->with('error', $message);
        } else {
            $productid = $request->productId;
            $product_name = $request->productName;
            $attribute = $request->colorChoose;
            $csscolor = $request->colorCss;
            $colorname = $request->colorNameP;
            $quantity  = $request->quantity;
            $liter    = isset($request->product_liters) ? $request->product_liters : "";
            $parent_product_img = Product::where('name','=',$product_name)->pluck('featured_image');
            $product = Product::find($productid);
            $item = [
                'product_attribute' => $attribute,
                'css_color' => $csscolor,
                'color_name' => $colorname,
                'product_details' => [
                    [ 
                        'id' => $product['id'],    
                        'name' => $product_name,
                        'image' => $parent_product_img !== null ? $parent_product_img[0] : "",
                        'qty' => $quantity,          
                        'price' => $product['price'],
                        'discount' => $product['discount'],
                        'discount_type' => $product['discount_type'],
                        'sale_price' => $product['sale_price'],
                        'description' =>  $product['description'],
                        'color'       => $colorname,
                        'liter' => $liter,
                        'shipping_weight' => $product['shipping_weight'],
                        'shipping_height' => $product['shipping_height'],
                        'shipping_length' => $product['shipping_length'],
                        'shipping_width' => $product['shipping_width'],
                        'is_sale' => $product['is_sale'],
                    ]
                ]
            ];
            if ($request->session()->has('gocart')) {
                $cart = $request->session()->get('gocart');
                $key = array_search($colorname, array_column($cart, 'color_name'));
                if($key !== false) {
                    foreach($cart[$key]['product_details'] as $cart_item_key => $cart_item) { 
                        if($item['product_details'][0]['id'] == $cart_item['id']) {
                            $cart[$key]['product_details'][$cart_item_key]['qty'] += $quantity;
                        } else {
                            array_push($cart[$key]['product_details'],$item['product_details'][0]);
                        }
                    }
                    $request->session()->put('gocart', $cart);
                } else {
                    $request->session()->push('gocart', $item);
                }
                $message = 'Item is successfully added to cart! &nbsp;&nbsp; <a href="/cart" class="view_cart"> View Cart </a>';
            }
            else {
                $request->session()->push('gocart', $item);
                $message = 'Item is successfully added to cart! &nbsp;&nbsp; <a href="/cart" class="view_cart"> View Cart </a>';
            }
            return redirect()->back()->with('success', $message);
        }
        
    }

    public function addcart(Request $request)
    {
        $message = '';
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'quantity' => 'required'
        ]);
        $message = '';
        if($validator->fails()){
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
            return redirect()->back()->with('error', $message);
        } else {
            $productid = $request->product_id;
            $color_ids = isset($request->color_ids) ? $request->color_ids : [] ;
            if(!isset($request->color_css) && !empty($color_ids))  {
                $color_data = Attribute::find(intval($color_ids[0]));
                $csscolor[0] = 'rgb('.$color_data->r_attr.','.$color_data->g_attr.','.$color_data->b_attr.')';
            }
            else {
                $csscolor = $request->color_css;
            }
            $colornames = isset($request->color_names) ? $request->color_names : [] ;
            $liters     = isset($request->product_liters) ? $request->product_liters : [] ;
            $quantity = $request->quantity;
            $product = Product::find($productid);
            
            // if(isset($request->prod_attri)) {
            //     $color_data = Attribute::find(intval($request->prod_attri[0]));
            //     $colornames  = [$color_data->name];
            //     $csscolor[0] = 'rgb('.$color_data->r_attr.','.$color_data->g_attr.','.$color_data->b_attr.')';
            // }
            if(!empty($colornames)) {
                foreach($colornames as $key => $colorname) {
                    $item = [
                        'product_attribute' => $color_ids[$key],
                        'css_color' => $csscolor[$key],
                        'color_name' => $colorname,
                        'product_details' => [
                            [ 
                                'id' => $product['id'],    
                                'name' => $product['name'],
                                'image' => $product['featured_image'],
                                'qty' => $quantity[$key],                    
                                'price' => isset($request->product_prices) ? floatval($request->product_prices[$key]) : $product['price'],
                                'discount' => $product['discount'],
                                'discount_type' => $product['discount_type'],
                                'sale_price' => $product['sale_price'],
                                'description' =>  $product['description'],
                                'color'       => $colorname,
                                'liter'       => !empty($liters) ? $liters[$key] : "",
                                'shipping_weight' => $product['shipping_weight'],
                                'shipping_height' => $product['shipping_height'],
                                'shipping_length' => $product['shipping_length'],
                                'shipping_width' => $product['shipping_width'],
                                'is_sale' => $product['is_sale'],
                            ]
                        ]
                    ];

                    $message = $this->addCartItem($request,$item);
                }
            } else {

                $item = [
                    'product_attribute' => 0,
                    'css_color' => "none",
                    'color_name' => "none",
                    'product_details' => [
                        [ 
                            'id' => $product['id'],    
                            'name' => $product['name'],
                            'image' => $product['featured_image'],
                            'qty' => $quantity[0],                    
                            'price' => $product['price'],
                            'discount' => $product['discount'],
                            'discount_type' => $product['discount_type'],
                            'sale_price' => $product['sale_price'],
                            'description' =>  $product['description'],
                            'color'       => "",
                            'liter'       => "",
                            'shipping_weight' => $product['shipping_weight'],
                            'shipping_height' => $product['shipping_height'],
                            'shipping_length' => $product['shipping_length'],
                            'shipping_width' => $product['shipping_width'],
                            'is_sale' => $product['is_sale'],
                        ]
                    ]
                ];

                $message = $this->addCartItem($request,$item);
            }
            return redirect('cart')->with('success', $message);
        }
    }

    private function addCartItem($request,$item) {

        if ($request->session()->has('gocart')) {
            $cart = $request->session()->get('gocart');
            $key = array_search($item['color_name'], array_column($cart, 'color_name'));
            if($key !== false) {
                    foreach($cart[$key]['product_details'] as $cart_item_key => $cart_item) { 
                        if($item['product_details'][0]['id'] == $cart_item['id']) {
                            $cart[$key]['product_details'][$cart_item_key]['qty'] += $item['product_details'][0]['qty'];
                        } else {
                            array_push($cart[$key]['product_details'],$item['product_details'][0]);
                        }
                    }
                $request->session()->put('gocart', $cart);
            } else {
                $request->session()->push('gocart', $item);
            }
            $message = "Item is successfully added to cart";
        }
        else {
            $request->session()->push('gocart', $item);
            $message = "Item is successfully added to cart";
        }
        return $message;
    }

    public function addCartMultipleColors(Request $request) {

        dd($request->all());
        if(!Auth::user()) {

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
                'product_attribute' => $request->prodattri, 
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
    public function getdimension(Request $request)
    {
        $shippingdimension = ShippingDimension::all();
        echo json_encode($shippingdimension);
    }

    public function removecart(Request $request)
    {
        $cart = $request->session()->get('gocart'); 
        array_splice($cart, $request->cart_id, 1);
        $request->session()->put('gocart', $cart);
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