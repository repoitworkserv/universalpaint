<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator;
use DB;
use Config;
use Auth;
use App\UserImages;
use App\Shipping;
use App\ShippingDimension;
use App\ShippingGngRates;

class ShippingController extends Controller
{

    public $moduleIndex = 3.1;

    public function __construct()
    {
        //check permission
        $this->middleware('uac:'.$this->moduleIndex);
    }

    public function index()
    {
        $ShippingDimension      = ShippingDimension::get();
        $Shipping               = ShippingGngRates::paginate(10);
        $id = Auth::id();
        $uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
        return view('admin.master-record.shipping.index', compact('uimage','Shipping', 'ShippingDimension'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'location'  => 'required',
            'price0' => 'required',
            'price1' => 'required',
            'price2' => 'required',
            'price3' => 'required',
            'price4' => 'required',
            'price5' => 'required',
            'price6' => 'required',
            'price7' => 'required',
            'price8' => 'required',
            'price9' => 'required',
            'price10' => 'required',
            'price11' => 'required',
            'price12' => 'required',
            'price13' => 'required',
            'price14' => 'required',
            'price15' => 'required',
            'price16' => 'required',
            'price17' => 'required',
            'price18' => 'required',
            'price19' => 'required',

        ]);

        $message = '';
        if ($validator->fails()) {            
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
            return redirect()->back()->withInput()->with('error',$message);
        } else {
            $shipping = new ShippingGngRates;
            $shipping->location          = $request->location;
            $shipping->below05kg      = $request->price0;
            $shipping->below1kg     = $request->price1;
            $shipping->below3kg      = $request->price2;
            $shipping->below4kg     = $request->price3;
            $shipping->below5kg     = $request->price4;
            $shipping->below6kg     = $request->price5;
            $shipping->below7kg     = $request->price6;
            $shipping->below8kg     = $request->price7;
            $shipping->below9kg     = $request->price8;
            $shipping->below10kg    = $request->price9;
            $shipping->below11kg    = $request->price10;
            $shipping->below12kg    = $request->price11;
            $shipping->below13kg    = $request->price12;
            $shipping->below14kg    = $request->price13;
            $shipping->below15kg    = $request->price14;
            $shipping->below16kg    = $request->price15;
            $shipping->below17kg    = $request->price16;
            $shipping->below18kg    = $request->price17;
            $shipping->below19kg    = $request->price18;
        	$shipping->below20kg	= $request->price19;
            $shipping->status       = isset($request->status) ? 1 : 0;
            $shipping->save();
            $message = 'Shipping is successfuly added';

            return redirect()->back()->withInput()->with('success',$message);
        }
        
    }

    public function update(Request $request)
    {
		//dd($request->all());
        $validator = Validator::make($request->all(), [
            'e_location'                  => 'required',
        ]);

        $message = '';
        if ($validator->fails()) {            
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
            return redirect()->back()->withInput()->with('error', $message);
        } else {
            $shipping = ShippingGngRates::find($request->e_id);
            $shipping->location         = $request->e_location;
        	$shipping->below05kg      = $request->e_price0;
        	$shipping->below1kg     = $request->e_price1;
        	$shipping->below3kg      = $request->e_price2;
        	$shipping->below4kg     = $request->e_price3;
        	$shipping->below5kg     = $request->e_price4;
        	$shipping->below6kg     = $request->e_price5;
        	$shipping->below7kg     = $request->e_price6;
        	$shipping->below8kg     = $request->e_price7;
        	$shipping->below9kg     = $request->e_price8;
        	$shipping->below10kg    = $request->e_price9;
        	$shipping->below11kg    = $request->e_price10;
        	$shipping->below12kg    = $request->e_price11;
        	$shipping->below13kg    = $request->e_price12;
        	$shipping->below14kg    = $request->e_price13;
        	$shipping->below15kg    = $request->e_price14;
        	$shipping->below16kg    = $request->e_price15;
        	$shipping->below17kg    = $request->e_price16;
        	$shipping->below18kg    = $request->e_price17;
        	$shipping->below19kg    = $request->e_price18;
        	$shipping->below20kg	= $request->e_price19;
            $shipping->status       = isset($request->e_status) ? 1 : 0;
            $shipping->save();
            $message = 'Shipping is successfuly updated';

            return redirect()->back()->withInput()->with('success', $message);
        }
    }

    public function destroy($id)
    {
        $delete =  ShippingGngRates::find($id)->delete();
        $message = 'Supplier successfully deleted!';
        return redirect()->back()->withInput()->with('success', $message); 
    }

    public function update_shipping_dimension(Request $request)
    {
        
        //dd($request->all());
        $validator = Validator::make($request->all(), [
                'weight0'   => 'required',
        ]);

        $message = '';
        if ($validator->fails()) {            
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
            return redirect()->back()->withInput()->with('error', $message);
        } else {
            $index = ShippingDimension::count();
            $si = 0;
            for($in = 0; $index > $in; $in++){
                    
                $weightVal = $request->get('weight'.$in);
                $ids = $in + 1; 
                $shipping = ShippingDimension::find($ids);
                $shipping->weight  = floatval($weightVal);
                $saved = $shipping->save();
                //DB::table('shipping_dimension')->where('id', $ids)->update(['weight' => floatval($weightVal)]);
                //dd($ids,floatval($weightVal));
                //$shipping->fill($request->input())->save();
            } 
            
        }
        $message = 'Succesfully Updated';
        return redirect()->back()->withInput()->with('success', $message);
    }
    public function storeShipping(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'size' => 'required',
            'weight' => 'required',
        ]);

        $message = '';
        if ($validator->fails()) {            
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
            return redirect()->back()->withInput()->with('error',$message);
        } else {
            $shippingDem = new ShippingDimension;
            $shippingDem->size          = $request->size;
            $shippingDem->weight      = $request->weight;
            $shippingDem->height     = $request->height;
            $shippingDem->width      = $request->width;
            //$shipping->length       = $request->length;
            $shippingDem->save();
            $message = 'Shipping is successfuly added';

            return redirect()->back()->withInput()->with('success',$message);
        }
        
    }
}
